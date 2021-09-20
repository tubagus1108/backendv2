<?php

namespace App\Http\Controllers\Migrasi;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\MigrasiModel\MigrasiCountry;
use Illuminate\Http\Request;

class MigrasiCountryController extends Controller
{
    public function __construct()
    {
        set_time_limit(800000000000000000);
    }
    public function migrasiCountry()
    {
        $oldCountry = MigrasiCountry::orderBy('sort_id')->get();
        foreach($oldCountry as $item)
        {
            // $dapatin_nama_negara = $item->nama_negara = 'Indonesia';
            $exist = Country::where('negara',$item->nama_negara)->first();
            if(!$exist)
                Country::create([
                    'kode_negara' => $item->kode_negara,
                    'negara' => $item->nama_negara,
                ]);
        }
        return response()->json(['error' => false, 'message' => 'Migrate Success']);
    }

}
