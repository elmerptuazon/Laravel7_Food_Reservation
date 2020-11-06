<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FoodItem;
use Carbon\Carbon;
use App\CalendarCapacity;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.cart');
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
       
        if($convertFoodList == null) {
            return view('pages.cart');
        } else if ($request->cart_data == null) {
            return view('pages.cart');
        }else if($request->cart_data == "undefined") {
            return view('pages.cart');
        }
        
        $getFoodData = $this->getMeatAndSidedish($convertFoodList);
        
        $dateToday = Carbon::now()->format('Y-m-d');
        $calendar_capacity = CalendarCapacity::where('from_date', $dateToday)->where('active', 1)->first();

        return view('pages.cart', ['meat_list' => $getFoodData->meat_list, 'sidedish_list' => $getFoodData->sidedish_list, 'total_order'=>$getFoodData->total_amount, 'calendar_capacity'=>$calendar_capacity]);
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
