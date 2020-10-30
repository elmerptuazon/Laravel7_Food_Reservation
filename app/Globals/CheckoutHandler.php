<?php
namespace App\Globals;

use App\Models\Transaction as Txn;
use App\Models\PromoCode;
use App\Models\Package;
use App\Models\Transaction_slot;
use App\Client;

use Carbon\Carbon;
class CheckoutHandler
{
    public function success($txn_id)
    {
        $Txn = Txn::where('txn_id', $txn_id)->first();
        $Txn->txn_status = 1;
        $Txn->save();

        $package = Package::find($Txn->txn_package_id);

        $package_no_sessions = $package->package_no_sessions;

        $insert_slot = [];
        for($i = 1; $i <= $package_no_sessions; $i++)
        {
            $insert_slot[$i]['txn_id'] = $Txn->txn_id;
            $insert_slot[$i]['txn_slot_valid_until'] = Carbon::now()->addDays($package->package_valid_for);
            $insert_slot[$i]['txn_client_id'] = $Txn->txn_client_id;
            $insert_slot[$i]['created_at'] = Carbon::now();
            $insert_slot[$i]['updated_at'] = Carbon::now();
        }

        $Transaction_slot = Transaction_slot::where('txn_id', $Txn->txn_id)->count();

        if($Transaction_slot == 0)
        {
            Transaction_slot::insert($insert_slot);
        }

        if($Txn->promo_code_id)
        {
            $count_promocode_use =  Txn::where('promo_code_id', $Txn->promo_code_id)->where('txn_status', 1)->count();

            $PromoCode = PromoCode::find($Txn->promo_code_id);

            if($PromoCode)
            {
                $PromoCode->promo_code_used_no = $count_promocode_use;
                $PromoCode->save();
            }
        }
    }
}