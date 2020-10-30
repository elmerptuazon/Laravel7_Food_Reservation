<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';

    protected $fillable = [
        'foodid', 'foodname', 'orderid', 'quantity'
    ];

    public function order() {
        return $this->belongsTo('App\Order', 'orderid', 'id');
    }
}
