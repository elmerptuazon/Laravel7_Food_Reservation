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
Route::get('/', 'MainController@index')->name('customer_home');
// Route::get('/check', function() {
//     return view('paypal.success');
// });
Route::group(['prefix'=>'/', 'middleware'=>['checkiflogin']], function() {
    Route::resource('food', FoodItemController::class,)->only([
        'show',
    ]);
    Route::resource('order', OrderController::class,)->only([
        'show', 'store',
    ]);
    Route::resource('cart', CartController::class,)->only([
        'index', 'store'
    ]);
    Route::resource('payment', PaymentController::class,);

    Route::post('order/validation', 'OrderController@validateOrder');
});

Route::group(['prefix'=>'paypal', 'middleware'=>['checkiflogin']], function() {
    Route::get('success', 'Front\PackageController@AuthMemberPackagePaypalsuccess')->name('AuthMemberPackagePaypalsuccess');
	Route::get('fail', 'Front\PackageController@AuthMemberPackagePaypalcancel')->name('AuthMemberPackagePaypalcancel');
});

Route::group(['prefix'=>'paymaya', 'middleware'=>['checkiflogin']], function() {
    Route::get('/client/package/checkout/success', 'Front\PackageCheckoutController@packageCheckoutSuccess')->name('AuthMemberPackageCheckoutSuccess');
    Route::get('/client/package/checkout/failure', 'Front\PackageCheckoutController@packageCheckoutFailure')->name('AuthMemberPackageCheckoutFailure');
    Route::get('/client/package/checkout/cancel', 'Front\PackageCheckoutController@packageCheckoutCancel')->name('AuthMemberPackageCheckoutCancel');
});

Route::group(['prefix'=>'admin', 'middleware' => ['checkiflogin', 'checkifadmin']], function() {
    Route::resources([
        'food' => FoodItemController::class,
        'order' => OrderController::class,
        'order_items' => OrderItemController::class,
        'calendar_capacity' => CalendarCapacityController::class,
    ]);
    Route::get('/order/details/{id}', 'OrderController@showOrder');
});

Auth::routes();

