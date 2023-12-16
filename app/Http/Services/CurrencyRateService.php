<?php

namespace App\Http\Services;
use App\Models\CurrencyConvert;
use Illuminate\Http\Response;
use App\Models\CurrencyRate AS CurrencyRate;


class CurrencyRateService
{
    private string $apiToken;
    private string $apiUrl;
    private array $supportedCurrencies = ['TRY', 'EUR', 'RUB', 'CAD', 'BGN'];

    public function __construct()
    {
        $this->apiToken = config('currencyrate.api_key');
        $this->apiUrl = config('currencyrate.api_url');
    }

    public function apiRequest($method, $endPoint)
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => $this->apiUrl
        ]);

        $headers = [
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Accept' => 'application/json',
            "Content-Type" => "application/json"
        ];

        $response = $client->request($method, $endPoint, [
            'http_errors' => true,
            'headers' => $headers
        ]);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody();

        return ["statusCode" => $statusCode, "data" => $body];
    }

    public function getCurrencyRateData()
    {
        $apiRequest = self::apiRequest('GET', 'latest');
        $statusCode = $apiRequest["statusCode"];
        $body = json_decode($apiRequest["data"]);

        if ($statusCode === 200) {
            $rates = $body->response->rates;

            $arr = [
                "TRY" => $rates->TRY,
                "EUR" => $rates->EUR,
                "RUB" => $rates->RUB,
                "CAD" => $rates->CAD,
                "BGN" => $rates->BGN
            ];

            foreach ($arr as $key => $value){
                CurrencyRate::where('code', $key)->update([
                    'rate'  => $value
                ]);
            }

        }else{
            return response()->json([
                'message' => "Exchange rate service unavailable."
            ], 503);
        }
    }

    public function getConvertData($from, $to, $amount = 1): float
    {
        $endPoint = "convert?from=".$from."&to=".$to."&amount=".$amount;
        $apiRequest = self::apiRequest('GET', $endPoint);
        $statusCode = $apiRequest["statusCode"];
        $body = json_decode($apiRequest["data"]);

        if($statusCode === 200){
            CurrencyConvert::updateOrCreate(
                ["from" => $from, "to" => $to],
                ["value" => floatval($body->value), "updated_at" => date("Y-m-d H:i:s")]
            );
        }else{
            return response()->json([
                'message' => "Exchange rate service unavailable."
            ], 503);
        }

        return $body->value;
    }

    public function getCurrencyByCode($code): object
    {
        $code = strtoupper($code);
        $currency = CurrencyRate::where('code', $code)->first();

        if(in_array($code, $this->supportedCurrencies)){
            return response()->json([
                "code" => $currency["code"],
                "name" => $currency["name"],
                "symbol" => $currency["symbol"],
                "rate" => $currency["rate"],
            ]);
        }else{
            return response()->json([
                'message' => "Forwarded unsupported currency."
            ], 416);
        }
    }

    public function getCurrencyRateByCode($code): object
    {
        $code = strtoupper($code);
        $currency = CurrencyRate::where('code', $code)->first();

        if(in_array($code, $this->supportedCurrencies)){
            return response()->json([
                'rate' => $currency["rate"]
            ]);
        }else{
            return response()->json([
                'message' => "Forwarded unsupported currency."
            ], 416);
        }
    }

    public function convert($from, $to, $amount){
        $from = strtoupper($from);
        $to = strtoupper($to);
        $amount = $amount ? floatval($amount) : 1;

        if(in_array($from, $this->supportedCurrencies) && in_array($to, $this->supportedCurrencies)){
            $currency = CurrencyConvert::where([["from", $from], ["to", $to]])->first();

            $now = strtotime(date("Y-m-d H:i:s"));
            $lastUpdate = $currency? strtotime($currency["updated_at"]) : 0;
            $updateDiff = ($now - $lastUpdate) / 60;

            if ($currency && $updateDiff < 15){
                $value = $currency["value"];
            }else{
                $value =  self::getConvertData($from, $to);
            }

            return response()->json([
                'value' => $value*$amount
            ]);
        }else{
            return response()->json([
                'message' => "Forwarded unsupported currency."
            ], 416);
        }
    }
}
