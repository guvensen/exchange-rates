<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyRateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/get-currency-data', [CurrencyRateController::class, 'index']);
Route::get('/currency/{code}', [CurrencyRateController::class, 'getCurrencyByCode']);
Route::get('/currency-rate/{code}', [CurrencyRateController::class, 'getCurrencyRateByCode']);
Route::get('/convert', [CurrencyRateController::class, 'convert']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
