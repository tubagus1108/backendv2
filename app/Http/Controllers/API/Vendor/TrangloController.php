<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\VendorKurs;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TrangloController extends Controller
{
    public function forex(Request $request)
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
        // return $query;
        $username = $_ENV['TR_API_KEY'];
        $password = $_ENV['TR_PASSWORD'];
        $secret_key = $_ENV['TR_SECRET_KEY'];
        $domain = $_ENV['TR_DOMAIN'];
        $currency = $_ENV['TR_CURR_FROM'];
        // $rows = count($query);
        $result = [];
        foreach($query as $curr)
        {
            $key = md5($username . $currency . $curr . $secret_key);
            $auth = 'GLOREMIT ' . $username . ':' . $password . ':' . $key;
            $service_url = "http://staging-gloremit.tranglo.com:2014/v1/payments/forex/rates?CurrFrom=".$currency."&CurrTo=".$curr;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $service_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: $auth"
            ));

            $data = curl_exec($ch);
            curl_close($ch);
            $view = json_decode($data);
            $result[] = $view;
        }
        // return response()->json(['error' => false,'data' => $result]);
        // return $result;
        // dd($result);
        $i = 0;
        $currVendor = [];
        foreach($result as $item)
        {
            // $currVendor[] =  $result[$i]->CurrTo;
            // $currVendor[] =  $result[$i]->CurrRate;
            $dataCurrTo = Currency::where('curr_code',$result[$i]->CurrTo)->get();
            $dataCurr = Currency::where('curr_code',$result[$i]->CurrFrom)->get();
            // return $data[$i]->id;
            VendorKurs::create([
                'vendor_name' => 'Tranglo',
                'buy' => $result[$i]->CurrRate,
                'sell' => $result[$i]->CurrRate,
                'currency_code' => $result[$i]->CurrFrom,
                'currency_to' => $result[$i]->CurrTo,
                'status_active' => 1,
                'last_update' => Carbon::now('Asia/Jakarta'),
                'id_currency' => $dataCurr[0]->id,
                'id_currency_to' => $dataCurrTo[0]->id,
            ]);
            $i++;
        }
        return $currVendor;
    }
}
