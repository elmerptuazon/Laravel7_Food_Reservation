<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FoodItem;
use App\CalendarCapacity;
use Carbon\Carbon;

class FoodItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show(FoodItem $food)
    {
        $date_now = Carbon::now()->format('Y-m-d');
        $sidedish = FoodItem::where('type', 'sidedish')->orderBy('name')->get();
        $calendar_capacity = CalendarCapacity::where('from_date', '<=', $date_now)->where('to_date', '>=', $date_now)->first();

        if($calendar_capacity == null) {
            return response()->view('errors.NoDateAvailable', ['date_msg'=>'No available dates for order. Please contact administrator.'], 500);
        }

        $food['current_max_pcs'] = $this->computeRemainingMeatPcs($food->max_pcs_per_tray,$calendar_capacity->tray_remaining);

        if($food['current_max_pcs'] == 0) {
            return response()->view('errors.NoDateAvailable', ['date_msg'=>'This type of meat is unavailable at the moment. Please contact administrator.'], 500);
        }
        $items = array('food'=>$food, 'sidedish' => $sidedish, 'calendar_capacity' => $calendar_capacity);
        return view('pages.food')->with($items);
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
