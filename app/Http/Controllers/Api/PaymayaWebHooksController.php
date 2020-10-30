<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\Checkout;
use Aceraven777\PayMaya\Model\Checkout\Item;
use App\Libraries\PayMaya\User as PayMayaUser;
use Aceraven777\PayMaya\Model\Checkout\ItemAmount;
use Aceraven777\PayMaya\Model\Checkout\ItemAmountDetails;

use Aceraven777\PayMaya\API\Customization;
use Aceraven777\PayMaya\API\Webhook;

use App\Models\PaymayaLogs;
use App\Models\Transaction as Txn;
use App\Client;

use App\Globals\CheckoutHandler;

class PaymayaWebHooksController extends Controller
{
    public function success(Request $request)
    {
    	PayMayaSDK::getInstance()->initCheckout(
            env('PAYMAYA_PUBLIC_KEY'),
            env('PAYMAYA_SECRET_KEY'),
            env('PAYMAYA_MODE')
        );

    	$PaymayaLogs = new PaymayaLogs;
    	$PaymayaLogs->paymaya_logs_request = json_encode($request->toArray());
    	$PaymayaLogs->paymaya_logs_type = 'success';

	    $transaction_id = $request->get('id');
	    if (! $transaction_id) {
	        $PaymayaLogs->paymaya_logs_response = json_encode(['status' => false, 'message' => 'Transaction Id Missing']);
	        $PaymayaLogs->save(); return 1;
	    }
	    
	    $itemCheckout = new Checkout();
	    $itemCheckout->id = $transaction_id;

	    $checkout = $itemCheckout->retrieve();
	    $PaymayaLogs->paymaya_logs_response = json_encode($checkout);
	    $PaymayaLogs->save();

	    if ($checkout === false) 
	    {
	        $error = $itemCheckout::getError();
	        $PaymayaLogs->paymaya_logs_response = json_encode($error['message']);
	        $PaymayaLogs->save(); return 1;
	    }

	    $Txn = Txn::where('txn_paymaya_checkout_id', $transaction_id)->first();

	    if($Txn)
	    {
	    	if(isset($checkout->paymentStatus))
	    	{
	    		if($checkout->paymentStatus == 'PAYMENT_SUCCESS')
		    	{
		    		$CheckoutHandler = new CheckoutHandler; $CheckoutHandler->success($Txn->txn_id);
		    		$PaymayaLogs->txn_id = $Txn->txn_id;
		    	}
	    	}
	    	
	    	if(isset($checkout['paymentStatus']))
	    	{
	    		if($checkout['paymentStatus'] == 'PAYMENT_SUCCESS')
		    	{
		    		$CheckoutHandler = new CheckoutHandler; $CheckoutHandler->success($Txn->txn_id);
		    		$PaymayaLogs->txn_id = $Txn->txn_id;
		    	}
	    	}

	    }

	    $PaymayaLogs->save(); return 2;
    }

    public function error(Request $request)
    {
    	PayMayaSDK::getInstance()->initCheckout(
            env('PAYMAYA_PUBLIC_KEY'),
            env('PAYMAYA_SECRET_KEY'),
            env('PAYMAYA_MODE')
        );

    	$PaymayaLogs = new PaymayaLogs;
    	$PaymayaLogs->paymaya_logs_request = json_encode($request->toArray());
    	$PaymayaLogs->paymaya_logs_type = 'error';

	    $transaction_id = $request->get('id');
	    if (! $transaction_id) {
	        $PaymayaLogs->paymaya_logs_response = json_encode(['status' => false, 'message' => 'Transaction Id Missing']);
	        $PaymayaLogs->save(); return 1;
	    }
	    
	    $itemCheckout = new Checkout();
	    $itemCheckout->id = $transaction_id;

	    $checkout = $itemCheckout->retrieve();
	    $PaymayaLogs->paymaya_logs_response = json_encode($checkout);

	    if ($checkout === false) 
	    {
	        $error = $itemCheckout::getError();
	        $PaymayaLogs->paymaya_logs_response = json_encode($error['message']);
	        $PaymayaLogs->save(); return 1;
	    }

	    $PaymayaLogs->save(); return 1;
    }

    public function dropout(Request $request)
    {
    	PayMayaSDK::getInstance()->initCheckout(
            env('PAYMAYA_PUBLIC_KEY'),
            env('PAYMAYA_SECRET_KEY'),
            env('PAYMAYA_MODE')
        );

    	$PaymayaLogs = new PaymayaLogs;
    	$PaymayaLogs->paymaya_logs_request = json_encode($request->toArray());
    	$PaymayaLogs->paymaya_logs_type = 'dropout';

	    $transaction_id = $request->get('id');
	    if (! $transaction_id) {
	        $PaymayaLogs->paymaya_logs_response = json_encode(['status' => false, 'message' => 'Transaction Id Missing']);
	        $PaymayaLogs->save(); return 1;
	    }
	    
	    $itemCheckout = new Checkout();
	    $itemCheckout->id = $transaction_id;

	    $checkout = $itemCheckout->retrieve();
	    $PaymayaLogs->paymaya_logs_response = json_encode($checkout);

	    if ($checkout === false) 
	    {
	        $error = $itemCheckout::getError();
	        $PaymayaLogs->paymaya_logs_response = json_encode($error['message']);
	        $PaymayaLogs->save(); return 1;
	    }

	    $PaymayaLogs->save(); return 1;
    }
}
