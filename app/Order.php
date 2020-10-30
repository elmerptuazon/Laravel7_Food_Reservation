<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = [
        'userid', 'fname', 'lname', 'paymentid', 'delivery_fee', 'total_price', 'tray_remaining', 'trayid', 'status', 'payment_used'
    ];

    public function orderitem() {
        return $this->hasMany('App\OrderItem', 'id', 'orderid');
    }
}
