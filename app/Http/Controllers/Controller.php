<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="An Exchange Rates API",
 *    version="0.0.1"
 * ),
 * @OA\SecurityScheme(
 *   type="http",
 *   description="Authentication Bearer Token",
 *   name="Authentication Bearer Token",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 *   securityScheme="bearer_token",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
