<?php

namespace App\Http\Controllers\Migrasi;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\MigrasiModel\MigrasiCurrency;
use Illuminate\Http\Request;

class MigrasiCurrencyController extends Controller
{
    public function __construct()
    {
        set_time_limit(800000000000000000);
    }
    public function migrasiCurrency()
    {
        $oldCurrency = MigrasiCurrency::all();
        foreach($oldCurrency as $item)
        {
            $exist = Currency::where('negara', $item->negaraa)->first();
            if(!$exist)
                Currency::create(['curr_code' => $item->curr_code,'negara' => $item->negara,'int_name' => $item->int_name]);
        }
        return response()->json(['error' => false, 'message' => 'Migrate Success']);
    }
}
