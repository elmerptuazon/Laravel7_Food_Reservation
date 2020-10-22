<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MainController@index');

Route::resource('food', FoodItemController::class,)->only([
    'show',
]);
Route::resource('order', OrderController::class,)->only([
    'show',
]);

Route::group(['prefix'=>'admin'], function() {
    Route::resources([
        'food' => FoodItemController::class,
        'order' => OrderController::class,
        'order_items' => OrderItemController::class,
        'calendar_capacity' => CalendarCapacityController::class,
    ]);
});

Auth::routes();

