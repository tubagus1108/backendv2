<?php

namespace App\Http\Controllers\Migrasi;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\MigrasiModel\MigrasiProvince;
use App\Models\Province;
use Illuminate\Http\Request;

class MigrasiProvinceController extends Controller
{
    public function __construct()
    {
        set_time_limit(800000000000000000);
    }
    public function migrasiProvince()
    {
        $oldCountry = MigrasiProvince::all();
        foreach($oldCountry as $item)
        {
            $data_country = Country::where('deleted_at',null)->get();
            // return $data_country[0]->id;
            $exist = Province::where('nama_province',$item->nama_prov)->first();
            if(!$exist)
                Province::create([
                    'kode_prov' => $item->kode_prov,
                    'id_country' => $data_country[0]->id,
                    'nama_province' => $item->nama_prov,
                ]);
        }
        return response()->json(['error' => false, 'message' => 'Migrate Success']);
    }
}
