<?php

namespace App\Http\Controllers;

use App\Http\Services\CurrencyRateService;
use Illuminate\Http\Request as Request;

class CurrencyRateController extends Controller
{

    public function index(CurrencyRateService $currencyRateService)
    {
        return $currencyRateService->getCurrencyRateData();
    }

    public function getCurrencyByCode(string $code, CurrencyRateService $currencyRateService)
    {
        return $currencyRateService->getCurrencyByCode($code);
    }

    public function getCurrencyRateByCode(string $code, CurrencyRateService $currencyRateService)
    {
        return $currencyRateService->getCurrencyRateByCode($code);
    }

    public function convert(Request $request, CurrencyRateService $currencyRateService)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $amount = $request->input('amount');

        return $currencyRateService->convert($from, $to, $amount);
    }

}
