<?php
namespace App\Globals;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\Checkout;
use Aceraven777\PayMaya\Model\Checkout\Item;
use App\Libraries\PayMaya\User as PayMayaUser;
use Aceraven777\PayMaya\Model\Checkout\ItemAmount;
use Aceraven777\PayMaya\Model\Checkout\ItemAmountDetails;

use Aceraven777\PayMaya\API\Customization;
use Aceraven777\PayMaya\API\Webhook;

use App\Models\Transaction as Txn;
use App\Client;

use App\Order;
use App\OrderItem;
use App\CalendarCapacity;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Crypt;

class Paymaya extends Controller
{
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

        return $this->paymayaCheckout($Txn, $client);
    }

    public function paymayaCheckout($payment_details)
    {

        PayMayaSDK::getInstance()->initCheckout(
            env('PAYMAYA_PUBLIC_KEY'),
            env('PAYMAYA_SECRET_KEY'),
            env('PAYMAYA_MODE')
        );

        $shopCustomization = new Customization();
        $shopCustomization->logoUrl = "https://ultralagree.ph/Front/Theme/Logo/long-logo-ul.png";
        $shopCustomization->iconUrl = "https://ultralagree.ph/Front/Theme/Logo/UL_Monogram%20B_180.png";
        $shopCustomization->appleTouchIconUrl = "https://ultralagree.ph/Front/Theme/Logo/UL_Monogram%20B_180.png";
        $shopCustomization->customTitle = "ULTRALAGREE PAYMAYA CHECKOUT";
        $shopCustomization->colorScheme = "#000000";
        $shopCustomization->set();
        
        $this->clearWebhooks();

        $successWebhook = new Webhook();
        $successWebhook->name = Webhook::CHECKOUT_SUCCESS;
        $successWebhook->callbackUrl = route('WebhooksPaymayaSuccess');
        $successWebhook->register();

        $failureWebhook = new Webhook();
        $failureWebhook->name = Webhook::CHECKOUT_FAILURE;
        $failureWebhook->callbackUrl = route('WebhooksPaymayaError');
        $failureWebhook->register();

        $dropoutWebhook = new Webhook();
        $dropoutWebhook->name = Webhook::CHECKOUT_DROPOUT;
        $dropoutWebhook->callbackUrl = route('WebhooksPaymayaDropout');
        $dropoutWebhook->register();


        // Item
        $itemAmountDetails = new ItemAmountDetails();
        $itemAmountDetails->tax = "0.00";
        $itemAmountDetails->subtotal = number_format($payment_details->total_amount, 2, '.', '');
        $itemAmount = new ItemAmount();
        $itemAmount->currency = "PHP";
        $itemAmount->value = $itemAmountDetails->subtotal;
        $itemAmount->details = $itemAmountDetails;
        $item = new Item();
        // $item->name = $Txn->txn_package_name;
        $item->name = 'Sunday Smoker';
        $item->amount = $itemAmount;
        $item->totalAmount = $itemAmount;
        
        
        // Checkout
        $itemCheckout = new Checkout();

        $user = new PayMayaUser();
        $user->firstName = $payment_details['user_info']->fname;
        $user->middleName = '';
        $user->lastName = $payment_details['user_info']->lname;
        $user->contact->phone = $payment_details['user_info']->mobile;
        $user->contact->email = $payment_details['user_info']->email;

        $dateSelected = CalendarCapacity::where('from_date', $payment_details['date'])->first();
        $collectDailyCapacity = array();
        foreach($payment_details['item_info']->meat_list as $meatkey => $meatvalue) {
            $dailyCapacity = $this->computeDailyCapacity($meatvalue->order, $meatvalue->max_pcs_per_tray);
            array_push($collectDailyCapacity, $dailyCapacity);
        }
        $capacityRemaining = $this->computeRemainingTray($dateSelected->tray_remaining, array_sum($collectDailyCapacity));
        
        $order = Order::create([
            "paymentid" => $itemCheckout->id,
            'userid' => $payment_details['user_info']->id,
            'fname' => $payment_details['user_info']->fname,
            'lname' => $payment_details['user_info']->lname,
            "status" => 0,
            "total_price" => $payment_details->total_amount,
            "tray_remaining" => (float)$capacityRemaining->exact_amount,
            "payment_used" => "paymaya",
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


        
        $itemCheckout->buyer = $user->buyerInfo();
        $itemCheckout->items = array($item);
        $itemCheckout->totalAmount = $itemAmount;
        $itemCheckout->requestReferenceNumber = str_pad(1, 9, '0');
        $itemCheckout->redirectUrl = array(
            // "success" => route('AuthMemberPackageCheckoutSuccess') . '?t_id=' . \Crypt::encrypt($Txn->txn_id) ,
            // "failure" => route('AuthMemberPackageCheckoutFailure') . '?t_id=' . \Crypt::encrypt($Txn->txn_id) ,
            // "cancel" => route('AuthMemberPackageCheckoutCancel') . '?t_id=' . \Crypt::encrypt($Txn->txn_id) ,
            "success" => route('AuthMemberPackageCheckoutSuccess') . '?t_id=' . Crypt::encryptString($order->id) ,
            "failure" => route('AuthMemberPackageCheckoutFailure') . '?t_id=' . Crypt::encryptString($order->id) ,
            "cancel" => route('AuthMemberPackageCheckoutCancel') . '?t_id=' . Crypt::encryptString($order->id) ,
        );

        if ($itemCheckout->execute() === false) {
            $error = $itemCheckout::getError(); 
            OrderItem::where('orderid', $order->id)->delete();
            $order->delete();
            $return['status'] = 0; $return['message'] = "There is a problem with the paymaya payment gateway, please contact the administrator"; $return['error'] = $error; $return['link'] = ''; return response()->json($return);
        }

        if ($itemCheckout->retrieve() === false) {
            $error = $itemCheckout::getError();
            OrderItem::where('orderid', $order->id)->delete();
            $order->delete();
            $return['status'] = 0; $return['message'] = "There is a problem with the paymaya payment gateway, please contact the administrator"; $return['error'] = $error; $return['link'] = ''; return response()->json($return);
        }

        $order->paymentid = $itemCheckout->id;
        $order->save();
        

        $return['status'] = 1; $return['message'] = 'Redirecting to paymaya'; $return['link'] = $itemCheckout->url; return response()->json($return);

    }

    private function clearWebhooks()
    {
        $webhooks = Webhook::retrieve();
        foreach ($webhooks as $webhook) {
            $webhook->delete();
        }
    }

}