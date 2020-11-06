<?php
namespace App\Globals;

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

use Illuminate\Http\Request;
use App\Order;
use App\OrderItem;
use App\User;
use App\CalendarCapacity;
use App\Http\Controllers\Controller;

class Paypal extends Controller
{

    protected $data = [];
    public function __construct()
    {
        $paypal_conf = \Config::get('paypal');
 
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        
        $this->_api_context->setConfig($paypal_conf['settings']);
        
    }

    public function checkout($txn_)
    {
        $Txn = new Txn;

        $Txn->txn_package_id                        = $txn_->txn_package_id;
        $Txn->txn_client_id                         = $txn_->txn_client_id;
        $Txn->txn_status                            = $txn_->txn_status;
        $Txn->txn_payment_type_id                   = $txn_->txn_payment_type_id;
        $Txn->txn_package_name                      = $txn_->txn_package_name;
        $Txn->txn_amount                            = $txn_->txn_amount;
        $Txn->txn_session_number                    = $txn_->txn_session_number;
        $Txn->promo_code_id                         = $txn_->promo_code_id;

        $Txn->txn_discount_value                    = $txn_->txn_discount_value;
        $Txn->txn_discount_value_type               = $txn_->txn_discount_value_type;
        $Txn->txn_discount_amount_before_discount   = $txn_->txn_discount_amount_before_discount;
        $Txn->txn_discount_amount_final             = $txn_->txn_discount_amount_final;

        $Txn->save();

        $client = Client::find($Txn->txn_client_id);

        return $this->paypalcheckout($Txn, $client);
    }

    // public function paypalcheckout($Txn, $client)
    public function paypalcheckout($payment_details)
    {   
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        // foreach($payment_details->meat_list as $key=>$val) {
        //     $item_1[$key] = new Item();
        //     $item_1[$key]->setName(ucwords($val['name']))->setCurrency('PHP')->setQuantity($val['order'])->setPrice($val['unit_price']);
        // }
        
        // $item_1->setName('Sunday Smoker')->setCurrency('PHP')->setQuantity(1)->setPrice($Txn->txn_amount);
        // $item_1->setName('Order')->setCurrency('PHP')->setQuantity(1)->setPrice(25);
        // $item_list = new ItemList();
        // $item_list->setItems($item_1);
        
        $amount = new Amount();
        $amount->setCurrency('PHP')->setTotal($payment_details->total_amount);
        
        $transaction = new Transaction();
        // $transaction->setAmount($amount)->setItemList($item_list)->setDescription('Your Transaction Desc');
        $transaction->setAmount($amount)->setDescription('Your Transaction Desc');

        $redirect_urls = new RedirectUrls(); 
        $redirect_urls->setReturnUrl(route('AuthMemberPackagePaypalsuccess'))->setCancelUrl(route('AuthMemberPackagePaypalcancel'));
        // $redirect_urls->setReturnUrl(url('/payment/success'))->setCancelUrl(url('/payment/fail'));
        
        $payment = new Payment();
        $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        }
        catch (\PayPal\Exception\PPConnectionException $ex) 
        {
           
            if (\Config::get('app.debug')) 
            {
                $return['status'] = 0; $return['message'] = "Connection timeout. Please contact the administrator"; $return['error'] = $error['message']; $return['link'] = ''; return response()->json($return);
            }
            else
            {
                $return['status'] = 0; $return['message'] = "Unknown error occurred (Paypal). Please contact the administrator"; $return['error'] = $error['message']; $return['link'] = ''; return response()->json($return);
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
        
        $dateSelected = CalendarCapacity::where('from_date', $payment_details['date'])->first();
        $collectDailyCapacity = array();
        foreach($payment_details['item_info']->meat_list as $meatkey => $meatvalue) {
            $dailyCapacity = $this->computeDailyCapacity($meatvalue->order, $meatvalue->max_pcs_per_tray);
            array_push($collectDailyCapacity, $dailyCapacity);
        }
        $capacityRemaining = $this->computeRemainingTray($dateSelected->tray_remaining, array_sum($collectDailyCapacity));
        $order = Order::create([
            "paymentid" => $payment->getId(),
            'userid' => $payment_details['user_info']->id,
            'fname' => $payment_details['user_info']->fname,
            'lname' => $payment_details['user_info']->lname,
            "status" => 0,
            "total_price" => $payment_details->total_amount,
            "tray_remaining" => (float)$capacityRemaining->exact_amount,
            "payment_used" => "paypal",
            "trayid" => (int)$dateSelected->id
        ]);
 
        foreach($payment_details['item_info']->sidedish_list as $meatid => $sidedishes) {
            OrderItem::create([
                'foodid'=>$payment_details['item_info']->meat_list[$meatid]->id,
                'foodname'=>$payment_details['item_info']->meat_list[$meatid]->name,
                'orderid'=> $order->id,
                'quantity'=>$payment_details['item_info']->meat_list[$meatid]->order
            ]);
            foreach($sidedishes as $sidedishid => $sidedish) {
                if($sidedish != (object)array()) {
                    OrderItem::create([
                        'foodid'=>$payment_details['item_info']->sidedish_list[$meatid][$sidedishid]->id,
                        'foodname'=>$payment_details['item_info']->sidedish_list[$meatid][$sidedishid]->name,
                        'orderid'=> $order->id,
                        'quantity'=>$payment_details['item_info']->sidedish_list[$meatid][$sidedishid]->order
                    ]);
                }
            }
        }
       
        if (isset($redirect_url)) 
        {
            $return['status'] = 1; $return['message'] = 'Redirecting to paypal'; $return['link'] = $redirect_url; return response()->json($return);
        }
        
        $return['status'] = 0; $return['message'] = "Unknown error occurred (Paypal). Please contact the administrator"; $return['error'] = $error['message']; $return['link'] = ''; return response()->json($return);
        
    }
    

}