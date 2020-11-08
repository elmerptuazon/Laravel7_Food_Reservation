<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FoodItem;
use Carbon\Carbon;
use App\CalendarCapacity;
use App\Order;
use App\OrderItem;
use Illuminate\Support\Facades\Validator;
use Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->paginate(10);
        
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
        $convertFoodList = (object)json_decode($request->cart_data);
        
        if(!$dateSelected) {
            return response()->json(['error'=>'No date available. Please contact admin.', 'error_id'=>1]);
        } else if($dateSelected->active == 0) {
            return response()->json(['error'=>'Date fully booked. Please pick another date.', 'error_id'=>1]);
        }else if($dateSelected->tray_remaining == 0.00) {
            return response()->json(['error'=>'Date fully booked. Please pick another date.', 'error_id'=>1]);
        }

        $getFoodData = $this->getMeatAndSidedish($convertFoodList);
        $collectDailyCapacity = array();
       
        foreach($getFoodData->meat_list as $meatkey => $meatvalue) {
            $dailyCapacity = $this->computeDailyCapacity($meatvalue->order, $meatvalue->max_pcs_per_tray);
            array_push($collectDailyCapacity, $dailyCapacity);
        }
        $capacityRemaining = $this->computeRemainingTray($dateSelected->tray_remaining, array_sum($collectDailyCapacity));
        $hasRemainingCapacity = $this->hasRemainingCapacity($capacityRemaining->exact_amount);
      
        if($hasRemainingCapacity) {
            $order_array = array(
                'meat_list' =>$getFoodData->meat_list,
                'sidedish_list'=>$getFoodData->sidedish_list,
                'date'=>$request->input('date'),
                'tray_remaining'=>$capacityRemaining->exact_amount,
                'tray_id' => $dateSelected->id,
                'food_list' => $getFoodData->food_list,
                'total_amount' => $getFoodData->total_amount,
                'user_info'=>Auth::user()
            );    

            return response()->json(['status'=>'Success']);

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
    public function show(Request $request, $foodlist)
    {
        // $date_now = Carbon::now()->format('Y-m-d');
        // $convertFoodList = json_decode($foodlist);
        // $sidedishlist = [];
        // $dateToday = Carbon::now()->format('Y-m-d');

        // foreach($convertFoodList->meat as $id=>$val) {
        //     $meatlist = FoodItem::where('type', 'meat')->where('id', $id)->first();
        //     $meatlist->order = $val;
        // }

        // foreach($convertFoodList->sidedish as $id=>$val) {
        //     $sd = FoodItem::where('type', 'sidedish')->where('id', $id)->first();
        //     $sd->order = $val;
        //     array_push($sidedishlist, $sd);
        // }

        // $calendar_capacity = CalendarCapacity::where('from_date', $dateToday)->first();

        // $detailsArr = array(
        //     'meat_list' => $meatlist,
        //     'sidedish_list' => $sidedishlist,
        //     'calendar_capacity' => $calendar_capacity,
        // );
        
        return view('pages.order');
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
            'paid' => 'required',
            'totalfee' => 'required',
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
