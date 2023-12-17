<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request, UserService $userService)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|min:2|max:255',
            'email' => 'required|unique:users|email:rfc,dns',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json($errors, 416);
        }

        return $userService->register($name, $email, $password);
    }

    public function logs(Request $request, UserService $userService)
    {
        $email = $request->input('email');
        return $userService->logs($email);
    }
}
