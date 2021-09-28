<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class TrangloController extends Controller
{
    public function forex()
    {
        $data = Currency::where('deleted_at',null)->get();
        $query = [
            $data[0]['curr_code']
        ];
        $i=0;
        foreach($data as $item)
        {
            if($i!=0)
                $query[] = $item['curr_code'];
            $i++;
        }
        return $query;
        $username = $_ENV['TR_API_KEY'];
        $password = $_ENV['TR_PASSWORD'];
        $secret_key = $_ENV['TR_SECRET_KEY'];
        $domain = $_ENV['TR_DOMAIN'];
        $currency = $_ENV['TR_CURR_FROM'];
        $rows = count($query);

    }
}
