<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\VendorKurs;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class BCAController extends Controller
{
    /** Development */
	private static $main_url = 'https://devapi.klikbca.com:443'; // Change When Your Apps is Live
	private static $client_id = 'b095ac9d-2d21-42a3-a70c-4781f4570704'; // Fill With Your Client ID
	private static $client_secret = 'bedd1f8d-3bd6-4d4a-8cb4-e61db41691c9'; // Fill With Your Client Secret ID
	private static $api_key = 'dcc99ba6-3b2f-479b-9f85-86a09ccaaacf'; // DEV
	private static $api_secret = '5e636b16-df7f-4a53-afbe-497e6fe07edc'; // Fill With Your API Secret Key
	private static $access_token = null;
	private static $signature = null;
	private static $timestamp = null;
	private static $corporate_id = 'IBSDANAREM';
	// private static $server_url = 'http://localhost:8000/api/v1/vendor-kurs';
	// private static $server_url = 'http://dev-api2.adaremit.com/api/v1/vendor-kurs';
    private function getToken()
	{
		$path = '/api/oauth/token';

		$authorization = base64_encode(self::$client_id.':'.self::$client_secret);

		$headers = array(
			'Content-Type: application/x-www-form-urlencoded',
			'Authorization: Basic ' . $authorization,
		);

		$data = array(
			'grant_type' => 'client_credentials'
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::$main_url . $path);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore Verify SSL Certificate
		curl_setopt_array($ch, array(
			CURLOPT_POST => TRUE,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_POSTFIELDS => http_build_query($data),
		));
		$output = curl_exec($ch);
		curl_close($ch);
		// echo $output;

		$result = json_decode($output, true);
        // dd($result);
		self::$access_token = $result['access_token'];
	}

	private function getSignature($url, $method)
	{
		$relative_url = $url;
		$access_token = self::$access_token;
		$request_body = hash('sha256', '');
		$api_secret = self::$api_secret;

		/** timestamp */
		$timestamp = date(DateTime::ISO8601);
		$timestamp = str_replace('+', '.000+', $timestamp);
		$timestamp = substr($timestamp, 0, (strlen($timestamp) - 2));
		$timestamp .= ':00';

		/** signature */
		$stringToSign = "$method:$relative_url:$access_token:$request_body:$timestamp";
		$signature = hash_hmac('SHA256', $stringToSign, $api_secret);

		self::$timestamp = $timestamp;
		self::$signature = $signature;
        // dd($signature)
	}
    public function index()
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
        // return $query[0];
        $this->getToken();
        $path = '/general/rate/forex?CurrencyCode=&RateType=erate';
        $method = 'GET';
        // return $path;
        $this->getSignature($path, $method);

        $headers = array(
            'Authorization: Bearer ' . self::$access_token,
            'X-BCA-Key: ' . self::$api_key,
            'X-BCA-Timestamp: ' . self::$timestamp,
            'X-BCA-Signature: ' . self::$signature,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$main_url . $path);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore Verify SSL Certificate
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $output = curl_exec($ch); // This is API Response
        curl_close($ch);
        $data = json_decode($output,true);
        // return $dataBca;
        $vendor_bca = [];
        if(is_array($data))
        {
            $i = 0;
            foreach($data['Currencies'] as $row)
            {
                $CurrencyCode = 'IDR';
                $RateType = $row['RateDetail'][0]['RateType'];
				$Buy = $row['RateDetail'][0]['Buy'];
				$Sell = $row['RateDetail'][0]['Sell'];
				$LastUpdate = $row['RateDetail'][0]['LastUpdate'];
				$currency_to = $row['CurrencyCode'];

                // return $CurrencyCode;
                $dataCurrTo = Currency::where('curr_code',$currency_to)->get();
                // return $dataCurrTo[0]->id;
                $dataCurr = Currency::where('curr_code',$CurrencyCode)->get();
                VendorKurs::create([
                    'vendor_name' => 'BCA',
                    'rate_type' => $RateType,
                    'buy' => $Buy,
                    'sell' => $Sell,
                    'currency_code' => $CurrencyCode,
                    'currency_to' => $currency_to,
                    'status_active' => 1,
                    'last_update' => Carbon::now('Asia/Jakarta'),
                    'id_currency' => $dataCurr[0]->id,
                    'id_currency_to' => $dataCurrTo[0]->id,
                ]);
                $i++;
            }
            return "BCA AMAN UPDATE $i Record";
        }else{
            return "BCA Error Bro";
        }
        // return $CurrencyCode;
                // $dataCurrTo = Currency::where('curr_code',$item[0]->CurrencyCode)->get();
                // $dataCurr = Currency::where('curr_code',$CurrencyCode)->get();
                // VendorKurs::create([
                //     'vendor_name' => 'BCA',
                //     'rate_type' => $item[0]->RateDetail[0]->RateType,
                //     'buy' => $item[0]->RateDetail[0]->Buy,
                //     'sell' => $item[0]->RateDetail[0]->Sell,
                //     'currency_code' => $CurrencyCode,
                //     'currency_to' => $item[0]->CurrencyCode,
                //     'status_active' => 1,
                //     'last_update' => Carbon::now('Asia/Jakarta'),
                //     'id_currency' => $dataCurr[0]->id,
                //     'id_currency_to' => $dataCurrTo[0]->id,
                // ]);
        // return $vendor_bca;
	}

}
