<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FoodItem;

class MainController extends Controller
{
    public function index() {
        $food = FoodItem::where('type', 'meat')->orderBy('name')->get();
        return view('pages.main')->with(['food'=>$food]);
    }
}
