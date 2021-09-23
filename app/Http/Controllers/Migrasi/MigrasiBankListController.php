<?php

namespace App\Http\Controllers\Migrasi;

use App\Http\Controllers\Controller;
use App\Models\BankList;
use App\Models\Currency;
use App\Models\MigrasiModel\MigrasiBankList;
use Illuminate\Http\Request;

class MigrasiBankListController extends Controller
{
    public function __construct()
    {
        set_time_limit(800000000000000000);
    }
    public function migrasiBankList()
    {

        $oldBankList = MigrasiBankList::where('curr_id','AU')->where('t_service','Bank Deposit')->get();
        // return $oldBankList;
        foreach($oldBankList as $item)
        {
            $currency = Currency::where('int_name','AU')->get();
            // return $currency;
            $exist = BankList::where('name_bank',$item->nama_bank)->first();
            if(!$exist)
                BankList::create([
                    'name_bank' => $item->nama_bank,
                    'currency_id' => $currency[0]->id,
                    'code_tranglo' => $item->t_code,
                    'sentbe_code' => $item->s_master,
                    'service_id' => 1,
                ]);
        }
        return response()->json(['error' => false, 'message' => 'Migrate Success']);
    // }
    }

}
