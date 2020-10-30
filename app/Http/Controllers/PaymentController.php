<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Globals\Paypal;
use App\Globals\Paymaya;
use stdClass;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $meat = json_decode($request->get('details'));
        return view('pages.paymentoptions', ['details'=>$request->get('details'), 'meat'=>$meat->meat_list]);
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
        
        $checkPaymentUsed = $request->payment_used;
        $meat_list = $request->meat_list;
        $sidedish_list = $request->sidedish_list;
        $dateSelected = $request->date;
        $tray_remaining = $request->tray_remaining;
        $item_prices = [];
        $item_list = [];
        $items = new stdClass();

        $meat_sum = $this->computeFoodItemOrder((int)$meat_list["unit_price"], (int)$meat_list["order"]);
        array_push($item_prices, $meat_sum);
        $items->id = $meat_list["id"];
        $items->name = $meat_list["name"];
        $items->qty = (int)$meat_list["order"];
        $items->unit_price = (int)$meat_list["unit_price"];
        array_push($item_list, $items);
        
        if(isset($sidedish_list)) {
            foreach($sidedish_list as $val) {
                $sidedish_sum = $this->computeFoodItemOrder((int)$val["unit_price"], (int)$val["order"]);
                $items = new stdClass();
                $items->id = $val["id"];
                $items->name = $val["name"];
                $items->qty = (int)$val["order"];
                $items->unit_price = (int)$val["unit_price"];
                array_push($item_list, $items);
                array_push($item_prices, $sidedish_sum);
            }
    
        }
        
        $request['total_amount'] = array_sum($item_prices);
        $request['item_list'] = $item_list;

        if($checkPaymentUsed == 'paypal') {
            $paypal = new Paypal;
            return $paypal->paypalcheckout($request);
        }else if($checkPaymentUsed == 'paymaya') {
            $paymaya = new Paymaya;
            return $paymaya->paymayaCheckout($request);
        }
        
        // return response()->json($request);
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
