<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request, AuthService $authService)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        return $authService->login($email, $password);
    }

    public function logout(Request $request, AuthService $authService)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        return $authService->logout($email, $password);
    }
}
