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

    /**
     * @OA\Get(
     *     path="/api/currency/{code}",
     *     summary="Get currency detail (dollar based)",
     *     tags={"Currency"},
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         in="path",
     *         required=true,
     *         name="code",
     *         description="currency code (e.g. try, eur)",
     *         @OA\Schema(
     *           type="string"
     *        ),
     *      ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function getCurrencyByCode(string $code, CurrencyRateService $currencyRateService)
    {
        return $currencyRateService->getCurrencyByCode($code);
    }

    /**
     * @OA\Get(
     *     path="/api/currency/rate/{code}",
     *     summary="Get currency rate (dollar based)",
     *     tags={"Currency"},
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *        in="path",
     *        required=true,
     *        name="code",
     *        description="currency code (e.g. try, eur)",
     *        @OA\Schema(
     *          type="string"
     *       ),
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function getCurrencyRateByCode(string $code, CurrencyRateService $currencyRateService)
    {
        return $currencyRateService->getCurrencyRateByCode($code);
    }

    /**
     * @OA\Get(
     *     path="/api/currency/convert",
     *     summary="Currency convert",
     *     tags={"Currency"},
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *        in="query",
     *        required=true,
     *        name="from",
     *        description="The base currency you would like to use for your rates.",
     *        @OA\Schema(
     *          type="string"
     *       ),
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         required=true,
     *         name="to",
     *         description="The currency you would like to convert to",
     *         @OA\Schema(
     *           type="string"
     *        ),
     *      ),
     *      @OA\Parameter(
     *          in="query",
     *          required=false,
     *          name="amount",
     *          description="The amount to convert",
     *          @OA\Schema(
     *            type="float"
     *         ),
     *       ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function convert(Request $request, CurrencyRateService $currencyRateService)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $amount = $request->input('amount');

        return $currencyRateService->convert($from, $to, $amount);
    }

}
