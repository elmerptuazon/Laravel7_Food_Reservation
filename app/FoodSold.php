<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodSold extends Model
{
    protected $table = 'food_solds';

    protected $fillable = [
        'fooditemid',
    ];
}
