<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Globals\Paypal;
use App\Globals\Paymaya;
use stdClass;
use Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_info = Auth::user();
        return view('pages.paymentoptions', ['user_info'=>$user_info]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $convertFoodList = (object)json_decode($request->cart_data);
        $convertDate = json_decode($request->date);
        $getFoodData = $this->getMeatAndSidedish($convertFoodList);

        $checkPaymentUsed = $request->payment_used;
        
        $request['total_amount'] = $getFoodData->total_amount;
        $request['item_info'] = $getFoodData;
        $request['date'] = $convertDate;
        $request['user_info'] = Auth::user();

        if($checkPaymentUsed == 'paypal') {
            $paypal = new Paypal;
            return $paypal->paypalcheckout($request);
        }else if($checkPaymentUsed == 'paymaya') {
            $paymaya = new Paymaya;
            return $paymaya->paymayaCheckout($request);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
