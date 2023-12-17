<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyRateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

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

Route::middleware('audit')->group(function () {
    Route::get('/', function (){
        return "An Exchange Rates API";
    });
    Route::post('/user', [UserController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::middleware('auth:sanctum')->group(function () {
        //Route::get('/get-currency-data', [CurrencyRateController::class, 'index']);
        Route::get('/currency/convert', [CurrencyRateController::class, 'convert']);
        Route::get('/currency/rate/{code}', [CurrencyRateController::class, 'getCurrencyRateByCode']);
        Route::get('/currency/{code}', [CurrencyRateController::class, 'getCurrencyByCode']);
        Route::get('/user/logs', [UserController::class, 'logs']);
    });
});
