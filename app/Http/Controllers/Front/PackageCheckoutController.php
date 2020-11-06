<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Transaction as Txn;
use App\Models\PromoCode;
use App\Models\Package;
use App\Models\Transaction_slot;

use App\Globals\Paypal;
use App\Globals\Paymaya;
use App\Globals\CheckoutHandler;

use Carbon\Carbon;
use Auth;

use App\Client;

use App\Order;
use App\OrderItem;
use App\CalendarCapacity;
use App\User;

use Illuminate\Support\Facades\Crypt;

class PackageCheckoutController extends Controller
{
    public function packageCheckout(Request $request)
    {
    	if($request->promocode_type_id)
    	{
    		return $this->validatePromoCode($request);
    	}
    	else
    	{
            $txn = new \stdClass();
            $txn->txn_client_id         = Auth::User()->client_id;
            $txn->promo_code_id         = null;

            $package = Package::where('package_id', $request->package_id)->archive()->first();

            $txn->txn_status                            = 2;
            $txn->txn_payment_type_id                   = $request->payment_id;
            $txn->txn_package_name                      = $package->package_name;
            $txn->txn_package_id                        = $package->package_id;
            $txn->txn_amount                            = $package->package_price;
            $txn->txn_session_number                    = $package->package_no_sessions;

            $txn->txn_discount_value                    = 0;
            $txn->txn_discount_value_type               = 'fixed'; 
            $txn->txn_discount_amount_before_discount   = $package->package_price;
            $txn->txn_discount_amount_final             = $package->package_price;

            // Club100 discount
            $club100 = Txn::where('txn_client_id', Auth::User()->client_id)->where('txn_status', 1)->join('tbl_package', 'tbl_package.package_id', 'tbl_transaction.txn_package_id')->where('package_main', 1)->first();


            // Disable club_100 dicount on 12.12 discount
            if($package->package_id == 18){ $club100 = null; }
            if($package->package_is_promo == 1){ $club100 = null; }

            if($club100)
            {
                $txn->txn_discount_value                    = 5;
                $txn->txn_discount_value_type               = 'percent'; 
                $txn->txn_discount_amount_before_discount   = $package->package_price;
                $txn->txn_discount_amount_final             = $package->package_price - ($package->package_price * 0.05);
                $txn->txn_amount                            = $txn->txn_discount_amount_final;
            }

            // dd($txn);
            return $this->checkout($txn);
            
    	}
    }


    public function validatePromoCode(Request $request)
    {
    	// Validate Promocode
    	$return['status'] = 1; $return['message'] = 'success'; $return['link'] = '';

    	$Promocode = PromoCode::where('promo_code_id', $request->promocode_id)->details()->active()->first();

    	// Check if Promocode does exist
    	if($Promocode)
    	{	
    		// Check if already Claimed
    		$Txn = Txn::where('promo_code_id', $request->promocode_id)->where('txn_client_id', Auth::User()->client_id)->where('txn_status', 1)->first();

    		if(!$Txn)
    		{
    			// Check if promocode is still usable
	    		if($Promocode->promo_code_used_no < $Promocode->promo_code_use_no)
	    		{
	    			$today = Carbon::now();
	    			$Promocode->promo_code_valid_from = Carbon::createFromFormat('Y-m-d', $Promocode->promo_code_valid_from)->startOfDay();
	    			$Promocode->promo_code_valid_to = Carbon::createFromFormat('Y-m-d', $Promocode->promo_code_valid_to)->endOfDay();

	    			// Check if date is valid
	    			if($Promocode->promo_code_valid_from <= $today &&  $Promocode->promo_code_valid_to >= $today)
	    			{
                        $txn = new \stdClass();

						$txn->txn_client_id 		= Auth::User()->client_id;
						$txn->promo_code_id 		= $Promocode->promo_code_id;

						switch ($Promocode->promo_code_type_id) {
							// Free Package
							case 1:
									$txn->txn_status 			= 1;
									$txn->txn_payment_type_id	= 5;
									$txn->txn_package_name 	    = $Promocode->package_name;
									$txn->txn_package_id 		= $Promocode->package_id;
									$txn->txn_amount 			= 0;
									$txn->txn_session_number 	= $Promocode->package_no_sessions;
								break;
							// Discount Percentage	
							case 2:
                                    $package = Package::where('package_id', $request->package_id)->archive()->first();

                                    if($package)
                                    {
                                        $txn->txn_status                            = 2;
                                        $txn->txn_payment_type_id                   = $request->payment_id;
                                        $txn->txn_package_name                      = $package->package_name;
                                        $txn->txn_package_id                        = $package->package_id;
                                        $txn->txn_amount                            = $package->package_price;
                                        $txn->txn_session_number                    = $package->package_no_sessions;
                                        $txn->txn_discount_value                    = $Promocode->promo_code_value;
                                        $txn->txn_discount_value_type               = 'percent'; 
                                        $txn->txn_discount_amount_before_discount   = $package->package_price;
                                        $txn->txn_discount_amount_final             = $package->package_price - ($package->package_price * ($Promocode->promo_code_value/100));
                                        $txn->txn_amount                            = $txn->txn_discount_amount_final;
                                    }
                                    else
                                    {
                                        $return['status'] = 0; $return['message'] = 'Invalid Package, Please Try again.'; $return['link'] = ''; return response()->json($return);
                                    }
									
								break;
                            // Discount Fixed 
							case 3:
									$package = Package::where('package_id', $request->package_id)->archive()->first();

                                    if($package)
                                    {
                                        $txn->txn_status                            = 2;
                                        $txn->txn_payment_type_id                   = $request->payment_id;
                                        $txn->txn_package_name                      = $package->package_name;
                                        $txn->txn_package_id                        = $package->package_id;
                                        $txn->txn_amount                            = $package->package_price;
                                        $txn->txn_session_number                    = $package->package_no_sessions;
                                        $txn->txn_discount_value                    = $Promocode->promo_code_value;
                                        $txn->txn_discount_value_type               = 'fixed'; 
                                        $txn->txn_discount_amount_before_discount   = $package->package_price;
                                        $txn->txn_discount_amount_final             = $package->package_price - $Promocode->promo_code_value;
                                        $txn->txn_amount                            = $txn->txn_discount_amount_final;
                                    }
                                    else
                                    {
                                        $return['status'] = 0; $return['message'] = 'Invalid Package, Please Try again.'; $return['link'] = ''; return response()->json($return);
                                    }

								break;	
							default:
									$return['status'] = 0; $return['message'] = 'Something went wrong please contact the administator'; $return['link'] = ''; return response()->json($return);
								break;
						}
	    				return $this->checkout($txn);
	    			}else{ $return['status'] = 0; $return['message'] = 'Promo code is already expired'; $return['link'] = ''; }
	    		}else{ $return['status'] = 0; $return['message'] = 'All promo codes ('.$Promocode->promo_code_code.')  have been used'; $return['link'] = ''; }
    		}else{ $return['status'] = 0; $return['message'] = 'You already Claimed This Promo Code'; $return['link'] = ''; }
    	}else{ $return['status'] = 0; $return['message'] = 'Invalid Promocode'; $return['link'] = ''; }

    	return response()->json($return);
    }

    public function checkout($txn)
    {
    	$return['status'] = 0; $return['message'] = 'Something happened please call the administator'; $return['link'] = '';
    	switch ($txn->txn_payment_type_id) {
    		// Paypal
    		case 1:
    			$Paypal = new Paypal; return $Paypal->checkout($txn);
    		break;
    		case 4:
                $Paymaya = new Paymaya; return $Paymaya->checkout($txn);
    		break;
    		// Promo Code
    		case 5:
    			return $this->checkoutPromoCode($txn);
    		break;
    		// Invalid Payment Type
			default:
    			$return['status'] = 0; $return['message'] = 'Something happened please call the administator'; $return['link'] = '';
    		break;
    	}

    	return response()->json($return);
    }


    public function checkoutPromoCode($txn_)
    {
    	$Txn = new Txn;

    	$Txn->txn_package_id 		= $txn_->txn_package_id;
		$Txn->txn_client_id 		= $txn_->txn_client_id;
		$Txn->txn_status 			= $txn_->txn_status;
		$Txn->txn_payment_type_id 	= $txn_->txn_payment_type_id;
		$Txn->txn_package_name 		= $txn_->txn_package_name;
		$Txn->txn_amount 			= $txn_->txn_amount;
		$Txn->txn_session_number 	= $txn_->txn_session_number;
		$Txn->promo_code_id 		= $txn_->promo_code_id;

		$Txn->txn_discount_value 					= 0;
		$Txn->txn_discount_value_type 				= 'fixed';
		$Txn->txn_discount_amount_before_discount 	= 0;
		$Txn->txn_discount_amount_final 			= 0;

		$Txn->save();

		$promo_code_use_no = Txn::where('promo_code_id', $Txn->promo_code_id)->where('txn_status', 1)->count();

		$promoCode = PromoCode::where('promo_code_id', $Txn->promo_code_id)->first();
		if($promoCode){ $promoCode->promo_code_used_no = $promo_code_use_no; $promoCode->save(); } 

        $CheckoutHandler = new CheckoutHandler; $CheckoutHandler->success($Txn->txn_id);

		$return['status'] = 1; $return['message'] = 'Promo code/Package claimed please check Schedule tab to view your # sessions'; $return['link'] = '';

		return response()->json($return);
    }



    public function packageCheckoutSuccess(Request $request)
    {
        
        $paymentId = Crypt::decryptString($request->t_id);
        
        $order = Order::where('id', $paymentId)->firstOrFail();
    
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

        }

        // try {
        //     $Client = Client::where('client_id',$Txn->txn_client_id)->first();
        //     $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);

        //     $beautymail->send('front.member.paypal.success_email', $data, function($message) use ($Client)
        //     {
        //         $message
        //             ->from(Array(env('MAIL_FROM_ADDRESS')=>env('MAIL_FROM_NAME')))
        //             ->to($Client->client_email, $Client->client_fname . ' ' . $Client->client_lname )
        //             ->subject('Payment Success');
        //     });
        // }
        // catch (\Exception $e) {
        //     // $return['status']   = 'error';
        //     // $return['message']  = $e->getMessage(); 
        //     // return response()->json($return, 200);
        // }

        return view('paypal.success');

    }
    public function  packageCheckoutFailure(Request $request)
    {
        $paymentId = Crypt::decryptString($request->t_id);
        
        $order = Order::where('id', $paymentId)->firstOrFail();
    
        if(isset($order->paymentid))
        {
            OrderItem::where('orderid', $order->id)->delete();
            $order->delete();
        }

        return view('paypal.fail');
    }
    public function  packageCheckoutCancel(Request $request)
    {
        $paymentId = Crypt::decryptString($request->t_id);
        
        $order = Order::where('id', $paymentId)->firstOrFail();
    
        if(isset($order->paymentid))
        {
            OrderItem::where('orderid', $order->id)->delete();
            $order->delete();
        }

        return view('paypal.fail');
    }
}
