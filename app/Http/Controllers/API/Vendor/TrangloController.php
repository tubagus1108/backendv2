<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Currency;
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
        $username = $_ENV['TR_API_KEY'];
        $password = $_ENV['TR_PASSWORD'];
        $secret_key = $_ENV['TR_SECRET_KEY'];
        $domain = $_ENV['TR_DOMAIN'];
        $currency = $_ENV['TR_CURR_FROM'];
        // $rows = count($query);
        $key = md5($username . $currency . $query[0] . $secret_key);
        $auth = 'GLOREMIT ' . $username . ':' . $password . ':' . $key;
        $client = new Client();
        $url = "http://$domain/v1/payments/forex/rates?CurrFrom=".$currency."&CurrTo=".$query[0];
        $request = $client->get($url,[
            'headers' => ['Authorization' => $auth],
        ]);
        $body = $request->getBody();
        $view = json_decode($body);
        return $view;
    }
}
