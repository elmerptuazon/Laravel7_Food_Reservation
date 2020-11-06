<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\FoodItem;

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

    public function computeRemainingTray($max_tray, $used_tray) {
        $sum = (float)$max_tray - (float)$used_tray;
        $roundoffSum = (int)$this->roundDownNumber($sum);

        return (object)array(
            'total_remaining'=>$used_tray,
            'round_off_remaining'=>$roundoffSum,
            'exact_amount'=>$sum
        );

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

    public function getMeatAndSidedish($cart_data) {
        $collect_amount = [];
        
        foreach($cart_data->sidedish as $meatid => $sidedishes) {
            
            $meat_list[$meatid] = FoodItem::where('id', $meatid)->first();
            
            foreach($sidedishes as $sidedishid => $sidedish) {
               
                if((int)$sidedish != 0) {
                    
                    $sidedish_list[$meatid][$sidedishid] = FoodItem::where('id', $sidedishid)->first();
                    $sidedish_list[$meatid][$sidedishid]->order = $sidedish;
                    array_push($collect_amount, ((int)$sidedish_list[$meatid][$sidedishid]->unit_price * (int)$sidedish_list[$meatid][$sidedishid]->order));
                }else {
                    $sidedish_list[$meatid][$sidedishid] = (object)array();
                    // unset($cart_data->{'sidedish'}->{$meatid}->{$sidedishid});
                }
            }
            if($sidedishes == (object)array()) {
                $sidedish_list[$meatid] = (object)array();
            }
        }
       
        foreach($cart_data->meat as $meatid => $meatorder) {
            $meat_list[$meatid]->order = $meatorder;
            array_push($collect_amount, ((int)$meat_list[$meatid]->unit_price * (int)$meat_list[$meatid]->order));
        }

        return (object)array(
            'meat_list' => $meat_list,
            'sidedish_list' => $sidedish_list,
            'food_list' => $cart_data,
            'total_amount' => array_sum($collect_amount)
        );

    }
}
