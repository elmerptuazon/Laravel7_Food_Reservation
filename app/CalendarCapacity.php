<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarCapacity extends Model
{
    protected $table = 'calendar_capacities';

    protected $fillable = [
        'from_date', 'to_date', 'tray_capacity', 'tray_remaining', 'active'
    ];
}
