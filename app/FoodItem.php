<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    protected $table = 'food_item';

    protected $fillable = [
        'name', 'type', 'description', 'unit_price', 'active',
    ];
}
