<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = [
        'userid', 'total_price'
    ];

    public function orderitem() {
        return $this->hasMany('App\OrderItem', 'orderid');
    }
}
