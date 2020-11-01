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

class Paypal
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
        
        for($i = 0; $i <= (sizeof($payment_details->item_list)-1); $i++) {
            $item_1[$i] = new Item();
            $item_1[$i]->setName(ucwords($payment_details->item_list[$i]->name))->setCurrency('PHP')->setQuantity($payment_details->item_list[$i]->qty)->setPrice($payment_details->item_list[$i]->unit_price);
        }
        // $item_1->setName($Txn->txn_package_name)->setCurrency('PHP')->setQuantity(1)->setPrice($Txn->txn_amount);
        // $item_1->setName('Item 1')->setCurrency('PHP')->setQuantity(1)->setPrice(25);
        $item_list = new ItemList();
        $item_list->setItems($item_1);
        
        $amount = new Amount();
        $amount->setCurrency('PHP')->setTotal($payment_details->total_amount);
        
        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($item_list)->setDescription('Your Transaction Desc');

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

        $userinfo = User::create([
            'fname' => $payment_details->user_info['fname'],
            'lname' => $payment_details->user_info['lname'],
            'mobile' => $payment_details->user_info['mobile'],
            'email' => $payment_details->user_info['email'],
            'address1' => $payment_details->user_info['address'],
            'address2' => $payment_details->user_info['address'],
            'city' => $payment_details->user_info['city'],
            'province' => $payment_details->user_info['province'],
        ]);
        
        $order = Order::create([
            "paymentid" => $payment->getId(),
            'userid' => $userinfo->id,
            'fname' => $userinfo->fname,
            'lname' => $userinfo->lname,
            "status" => 0,
            "total_price" => $payment_details->total_amount,
            "tray_remaining" => (float)$payment_details->tray_remaining,
            "payment_used" => "paypal",
            "trayid" => (int)$payment_details->tray_id
        ]);
        for($i = 0; $i <= (sizeof($payment_details->item_list)-1); $i++) {
            OrderItem::create([
                'foodid'=>$payment_details->item_list[$i]->id,
                'foodname'=>$payment_details->item_list[$i]->name,
                'orderid'=> $order->id,
                'quantity'=>$payment_details->item_list[$i]->qty
            ]);
        }

        if (isset($redirect_url)) 
        {
            $return['status'] = 1; $return['message'] = 'Redirecting to paypal'; $return['link'] = $redirect_url; return response()->json($return);
        }
        
        $return['status'] = 0; $return['message'] = "Unknown error occurred (Paypal). Please contact the administrator"; $return['error'] = $error['message']; $return['link'] = ''; return response()->json($return);
        
    }
    

}