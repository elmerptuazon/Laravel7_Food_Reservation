<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FoodItem;
use Carbon\Carbon;
use App\CalendarCapacity;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        // return response()->json([$meatid, $sidedish]);
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
        //
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

        $calendar_capacity = CalendarCapacity::where('from_date', '<=', $date_now)->where('to_date', '>=', $date_now)->first();

        $detailsArr = array(
            'meat_list' => $meatlist,
            'sidedish_list' => $sidedishlist,
            'calendar_capacity' => $calendar_capacity,
        );

        return view('pages.order')->with($detailsArr);
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
