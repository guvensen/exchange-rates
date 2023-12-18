<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *          @OA\Property(
     *            property="email",
     *            description="Email address of the user.",
     *            type="string",
     *          ),
     *         @OA\Property(
     *            property="password",
     *            description="Password of the user.",
     *            type="string",
     *          ),
     *        ),
     *      ),
     *    ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function login(Request $request, AuthService $authService)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        return $authService->login($email, $password);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *          @OA\Property(
     *            property="email",
     *            description="Email address of the user.",
     *            type="string",
     *          ),
     *         @OA\Property(
     *            property="password",
     *            description="Password of the user",
     *            type="string",
     *          ),
     *        ),
     *      ),
     *    ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function logout(Request $request, AuthService $authService)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        return $authService->logout($email, $password);
    }
}
