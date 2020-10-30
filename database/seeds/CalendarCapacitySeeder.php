<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\CalendarCapacity;

class CalendarCapacitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date_now = Carbon::now()->format('Y-m-d');
        $date_next = Carbon::now()->addDays(2)->format('Y-m-d');

        CalendarCapacity::create([
            'from_date'=>$date_now,
            'to_date'=>$date_now,
            'tray_capacity'=>5,
            'tray_remaining'=>5,
            'active'=>1,
        ]);
    }
}
