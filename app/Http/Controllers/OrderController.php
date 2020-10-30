<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FoodItem;
use Carbon\Carbon;
use App\CalendarCapacity;
use App\Order;
use App\OrderItem;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->paginate(3);
        
        return view('pages.admin.order', ['orders' => $orders]);
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
        
        // OrderItem::create([
        //     'foodid' => $request->input('meat_list')['id'],
        //     'foodname' => $request->input('meat_list')['name'],
        //     'orderid' => 0,
        //     'quantity' => $request->input('meat_list')['order'],
        // ]);

        // if(sizeof($request->input('sidedish_list')) != 0) {
        //     foreach($request->input('sidedish_list') as $val) {
        //          OrderItem::create([
        //             'foodid' => $val['id'],
        //             'foodname' => $val['name'],
        //             'orderid' => 0,
        //             'quantity' => $val['order'],
        //         ]);
        //     }
        // }
        
    }

    public function validateOrder(Request $request) {
        $dateSelected = CalendarCapacity::where('from_date', $request->input('date'))->first();

        if(!$dateSelected) {
            return response()->json(['error'=>'No date available. Please contact admin.', 'error_id'=>1]);
        } else if($dateSelected->active == 0) {
            return response()->json(['error'=>'Date fully booked. Please pick another date.', 'error_id'=>1]);
        }

        $dailyCapacity = $this->computeDailyCapacity($request->input('meat_list')['order'], $request->input('meat_list')['max_pcs_per_tray']);
        $capacityRemaining = $this->computeRemainingTray($dateSelected->tray_remaining, [$dailyCapacity]);
        $hasRemainingCapacity = $this->hasRemainingCapacity($capacityRemaining);

        $order_array = array(
            'meat_list' =>$request->input('meat_list'),
            'sidedish_list'=>$request->input('sidedish_list'),
            'date'=>$request->input('date'),
            'tray_remaining'=>$capacityRemaining,
            'tray_id' => $dateSelected->id
        );
        
        if($hasRemainingCapacity) {
            return response()->json(['status'=>'success','details'=>$order_array]);
        }else {
            return response()->json(['error'=>'Not enough tray remaining. Please choose another date or reduce your items.', 'error_id'=>2]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($foodlist)
    {
        $date_now = Carbon::now()->format('Y-m-d');
        $convertFoodList = json_decode($foodlist);
        $sidedishlist = [];
        
        foreach($convertFoodList->meat as $id=>$val) {
            $meatlist = FoodItem::where('type', 'meat')->where('id', $id)->first();
            $meatlist->order = $val;
        }

        foreach($convertFoodList->sidedish as $id=>$val) {
            $sd = FoodItem::where('type', 'sidedish')->where('id', $id)->first();
            $sd->order = $val;
            array_push($sidedishlist, $sd);
        }

        $calendar_capacity = CalendarCapacity::where('id', $convertFoodList->calendar_capacity_id)->first();

        $detailsArr = array(
            'meat_list' => $meatlist,
            'sidedish_list' => $sidedishlist,
            'calendar_capacity' => $calendar_capacity,
        );
        
        return view('pages.order')->with($detailsArr);
    }

    public function showOrder($id) {
        $order = Order::where('id', $id)->first();
        return view('pages.admin.editorder', ['order' => $order]);
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
        $validatedData = Validator::make($request->all(), [
            'paid' => 'required|',
            'totalfee' => 'required|',
            'date' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->view('errors.500', [], 500);
        }

        Order::where('id', $id)->update([
            'paymentid' => $request->paid,
            'delivery_fee' => $request->deliveryfee,
            'total_price' => $request->totalfee,
            'created_at'=> $request->date
        ]);

        return response()->json(['status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::where('id', $id)->delete();
        OrderItem::where('orderid', $id)->delete();
        return response()->json(['status'=>'success']);
    }
}
