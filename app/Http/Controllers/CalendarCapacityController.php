<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CalendarCapacity;
use Illuminate\Support\Facades\Validator;

class CalendarCapacityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $calendarcap = CalendarCapacity::orderBy('from_date', 'desc')->paginate(10);
        $dateLatest = CalendarCapacity::orderBy('from_date', 'desc')->first();
  
        return view('pages.admin.calendarcapacity', ['calendarcaps' => $calendarcap, 'calendarlatest' => $dateLatest]);
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
        
        $validatedData = Validator::make($request->all(), [
            'traycap' => 'required|numeric',
            'date' => 'required',
        ]);
        
        if ($validatedData->fails()) {
            return response()->view('errors.500', [], 500);
        }

        $checkDateExists = CalendarCapacity::where('from_date', $request->date)->first();

        if($checkDateExists) {
            return response()->json(['error'=>'Date already exists. Please pick another one.', 'error_id'=>1]);
        }
        

        CalendarCapacity::create([
            'from_date' => $request->date,
            'to_date' => $request->date,
            'tray_capacity' => $request->traycap,
            'tray_remaining' => $request->traycap,
            'active'=>1
        ]);
        // return redirect()->back()->with('status', 'success');
        return response()->json(['status'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
        $details = CalendarCapacity::where('id', $id)->first();
        // return response()->json($details);
        return view('pages.admin.editcalendarcapacity', ['calendarcap'=>$details]);
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
            'traycap' => 'required|numeric',
            'date' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->view('errors.500', [], 500);
        }

        $checkDateExists = CalendarCapacity::where('from_date', $request->date)->first();

        if($checkDateExists) {
            return response()->json(['error'=>'Date already exists. Please pick another one.', 'error_id'=>1]);
        }

        CalendarCapacity::where('id', $id)->update([
            'from_date' => $request->date,
            'to_date' => $request->date,
            'tray_capacity' => $request->traycap,
            'tray_remaining'=> $request->trayremaining
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
        CalendarCapacity::where('id', $id)->delete();
        return response()->json(['status'=>'success']);
    }
}
