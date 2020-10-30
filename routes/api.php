<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('/paymaya/checkout/success', 'Api\PaymayaWebHooksController@success')->name('WebhooksPaymayaSuccess');
Route::any('/paymaya/checkout/error', 'Api\PaymayaWebHooksController@error')->name('WebhooksPaymayaError');
Route::any('/paymaya/checkout/dropout', 'Api\PaymayaWebHooksController@dropout')->name('WebhooksPaymayaDropout');