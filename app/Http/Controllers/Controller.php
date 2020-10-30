<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function  computeDailyCapacity($pcs_order, $item_max_capacity) {
        $computeTrayOrdered = $pcs_order / $item_max_capacity;
        $computedOrder = $this->roundDownNumber($computeTrayOrdered);

        return $computedOrder;
    }

    public static function roundDownNumber($num) {
        $value_times_100 = $num * 100;
        $value_times_100_floored = floor($value_times_100);
        $value_floored = $value_times_100_floored / 100;

        return $value_floored;
    }

    public function computeRemainingTray($max_tray, $used_tray=[]) {
        $sum = $max_tray - array_sum($used_tray);
        $roundoffSum = $this->roundDownNumber($sum);

        return $roundoffSum;

    }

    public function hasRemainingCapacity($remaining) {
        if($remaining > 0) {
            return true;
        }else {
            return false;
        }
    }

    public function computeFoodItemOrder($unit_price, $qty) {
        return $unit_price * $qty;
    }

    public function computeRemainingMeatPcs($max_pcs_per_tray, $tray_remaining) {
        $result = $max_pcs_per_tray * $tray_remaining;
        return (int)floor($result);
    }
}
