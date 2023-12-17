<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function register(string $name, string $email, string $password)
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);;

        if(!$user->save()){
            return response()->json([
                'message' => "Failed to register user."
            ], 400);
        }

        return response()->json([
            'message' => "The user has been created successfully."
        ], 201);
    }
}
