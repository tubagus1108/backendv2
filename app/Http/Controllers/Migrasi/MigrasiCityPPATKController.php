<?php

namespace App\Http\Controllers\Migrasi;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\MigrasiModel\MigrasiCityPPATK;
use App\Models\Province;
use Illuminate\Http\Request;

class MigrasiCityPPATKController extends Controller
{
    public function __construct()
    {
        set_time_limit(800000000000000000);
    }
    public function migrasiCity()
    {
        $oldCity = MigrasiCityPPATK::where('kode_prov_ppatk',99)->get();
        // return $oldCity;
        foreach($oldCity as $item)
        {
            $data_province = Province::where('deleted_at',null)->where('kode_prov',99)->get();
            // return $data_province;
            $exist = City::where('nama_city_ppatk',$item->nama_city_ppatk)->first();
            if(!$exist)
                City::create([
                    'kode_city_ppatk' => $item->kode_city_ppatk,
                    'kode_city_bi' => $item->kode_city_bi,
                    'id_province' => $data_province[0]->id,
                    'nama_city_ppatk' => $item->nama_city_ppatk,
                    'nama_city_bi' => $item->nama_city_bi,
                ]);
        }
        return response()->json(['error' => false, 'message' => 'Migrate Success']);
    }
}
