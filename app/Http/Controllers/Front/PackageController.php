<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Package;
use App\Models\Transaction as Txn;
use App\Models\Transaction_slot;
use App\Client;
use Auth;
use URL;
use Session;
use Redirect;
use Mail;
use Carbon\Carbon;

use App\Globals\CheckoutHandler;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\PaymentExecution;

use App\Order;
use App\OrderItem;
use App\CalendarCapacity;

class PackageController extends Controller
{
    protected $data = [];
    public function __construct()
    {
        /** PayPal api context **/
        Session::put('is_package', true);
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['Package'] = Package::where('package_is_status', 1)->frontviewable()->get();

        if(isset(Auth::User()->client_id))
        {
            $this->data['Package_one_time'] = Package::where('package_is_status', 1)
                ->where('package_is_onetime', '>=',  1)
                ->withCount(['transaction' => function ($query){
                    $query->where('txn_status', 1)->where('txn_client_id', Auth::User()->client_id);

                }])
                ->get()->keyBy('package_id');

                foreach($this->data['Package_one_time'] as $key => $value)
                {
                    if($value->transaction_count < $value->package_is_onetime)
                    {
                        unset($this->data['Package_one_time'][$key]);
                    }
                }
        }        
        return view('front.member.package.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buy($id)
    {
        $this->data['Package'] = Package::find($id);
        $this->data['Club_100'] = null;
        if($this->data['Package']->package_is_promo == 0)
        {
            $this->data['Club_100'] = Txn::where('txn_client_id', Auth::User()->client_id)->where('txn_status', 1)->join('tbl_package', 'tbl_package.package_id', 'tbl_transaction.txn_package_id')->where('package_main', 1)->first();
        }
        $this->data['Package_id'] = $id;
        $this->data['HasPromoCode'] = false;

        // Disable club_100 dicount on 12.12 discount
        if($id == 18){ $this->data['Club_100'] = null; }
        
        return view('front.member.package.promocode', $this->data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AuthMemberPackagePaypal(Request $request)
    {
        //
        if(Auth::User()->client_id)
        {
                
            $package = Package::find($request->package_id);

            $Txn = new Txn;
            $Txn->txn_package_id = $package->package_id;
            $Txn->txn_client_id = Auth::User()->client_id;
            $Txn->txn_status = 2;
            $Txn->txn_payment_type_id = 1;
            $Txn->txn_package_name = $package->package_name;
            $Txn->txn_amount = $package->package_price;
            $Txn->txn_session_number = $package->package_no_sessions;
            

            $Club_100 = Txn::where('txn_client_id', Auth::User()->client_id)->where('txn_status', 1)->join('tbl_package', 'tbl_package.package_id', 'tbl_transaction.txn_package_id')->where('package_main', 1)->first();
            if($Club_100)
            {
                $Txn->txn_amount = $Txn->txn_amount - ($Txn->txn_amount * 0.05);
            }

            $Txn->save();
                
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $item_1 = new Item();
            $item_1->setName($Txn->txn_package_name)->setCurrency('PHP')->setQuantity(1)->setPrice($Txn->txn_amount);
            $item_list = new ItemList();
            $item_list->setItems(array($item_1));
            
            $amount = new Amount();
            $amount->setCurrency('PHP')->setTotal($Txn->txn_amount);

            $transaction = new Transaction();
            $transaction->setAmount($amount)->setItemList($item_list)->setDescription($package->package_details);


            $redirect_urls = new RedirectUrls(); 
            $redirect_urls->setReturnUrl(URL::route('AuthMemberPackagePaypalsuccess'))->setCancelUrl(URL::route('AuthMemberPackagePaypalcancel'));

            $payment = new Payment();
            $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array($transaction));

            try {
                $payment->create($this->_api_context);
            }
            catch (\PayPal\Exception\PPConnectionException $ex) 
            {
                if (\Config::get('app.debug')) 
                {
                    \Session::put('error', 'Connection timeout'); return Redirect::route('paywithpaypal');
                }
                else
                {
                    \Session::put('error', 'Some error occur, sorry for inconvenient'); return Redirect::route('paywithpaypal');
                }
            }

            foreach ($payment->getLinks() as $link) 
            {
                if ($link->getRel() == 'approval_url') 
                {
                    $redirect_url = $link->getHref();
                    break;
                }    
            }

            /** add payment ID to session **/
            Session::put('paypal_payment_id', $payment->getId());

            $Txn->txn_paypal_token = $payment->getToken();
            $Txn->txn_paypal_id = $payment->getId();
            $Txn->save();

            if (isset($redirect_url)) 
            {
                return Redirect::away($redirect_url);
            }
            
            \Session::put('error', 'Unknown error occurred'); return Redirect::route('paywithpaypal');
        }
        else
        {
            return redirect()->route('ClientLogin');
        }
        
    }
    public function AuthMemberPackagePaypalsuccess(Request $request)
    {
        
        $payment_id = $request->paymentId;

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() != 'approved') {
            return redirect()->intended(route('AuthMemberPackagePaypalcancel'));
        }

        $order = Order::where('paymentid', $request->paymentId)->firstOrFail();
        // $Txn = Txn::where('txn_paypal_id', $request->paymentId)->firstOrFail();

        if(isset($order->paymentid))
        {
            $order->status=1;
            $order->save();
            $calendarCapacity = CalendarCapacity::where('id', $order->trayid)->first();
            $calendarCapacity->tray_remaining = $order->tray_remaining;
            $calendarCapacity->save();
            if($calendarCapacity->tray_remaining == 0) {
                $calendarCapacity->active = 0;
                $calendarCapacity->save();
            }

            // $CheckoutSuccess = new CheckoutHandler; $CheckoutSuccess->success($Txn->txn_id);

        }
        
        // $Txn->txn_paypal_token = $request->token;
        // $Txn->txn_paypal_PayerID = $request->PayerID;
        // $Txn->txn_status = 1;
        // $Txn->save();

        // $package = Package::find($Txn->txn_package_id);

        // $this->data['Txn']      = $Txn;
        // $this->data['package']  = $package;
        // $this->data['slot']     = Transaction_slot::where('txn_id', $Txn->txn_id)->select('*', \DB::raw('count(distinct(txn_slot_id)) as count_txn_slot_id'))->first();

        // try {
        //     $Client = Client::where('client_id',$Txn->txn_client_id)->first();
        //     $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        //     $beautymail->send('front.member.paypal.success_email', $this->data, function($message) use ($Client)
        //     {
        //         $message
        //             ->from(Array(env('MAIL_FROM_ADDRESS')=>env('MAIL_FROM_NAME')))
        //             ->to($Client->client_email, $Client->client_fname . ' ' . $Client->client_lname )
        //             ->subject('Payment Success');
        //     });
        // }
        // catch (\Exception $e) {
        //     $return['status']   = 'error';
        //     $return['message']  = $e->getMessage(); 
        //     return response()->json($return, 200);
        // }

        // return view('front.member.paypal.success', $this->data);
        return view('paypal.success');
    }
    public function AuthMemberPackagePaypalcancel(Request $request)
    {
        $order = Order::where('paymentid', $request->paymentId)->firstOrFail();
        // $Txn = Txn::where('txn_paypal_id', $request->paymentId)->firstOrFail();

        if(isset($order->paymentid))
        {
            OrderItem::where('orderid', $order->id)->delete();
            $order->delete();
            // $CheckoutSuccess = new CheckoutHandler; $CheckoutSuccess->success($Txn->txn_id);
        }
        // $Txn = Txn::where('txn_paypal_token', $request->token)->firstOrFail();
        // $Txn->txn_status = 2;
        // $Txn->save();

        // return view('front.member.paypal.cancel', $this->data);
        return view('paypal.fail');
    }
    public function MWprotect()
    {}
}

