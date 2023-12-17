<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    public function login(string $email, string $password)
    {
        $user = Auth::attempt(['email' => $email, 'password' => $password]);

        if(!$user){
            return response()->json([
                'message' => "Email or password is incorrect"
            ], 403);
        }else{
            if(!PersonalAccessToken::where('tokenable_id', auth()->id())->first()){
                $token = Auth::getUser()->createToken('accessToken');
                $token = explode("|", $token->plainTextToken);

                return response()->json([
                    'token' => $token[1]
                ], 200);
            }else{
                return response()->json([
                    'message' => "You already have an access token. If you lost the token, logout and get a new token."
                ], 200);
            }
        }
    }

    public function logout($email, $password)
    {
        $user = Auth::attempt(['email' => $email, 'password' => $password]);

        if(!$user){
            return response()->json([
                'message' => "Email or password is incorrect"
            ], 403);
        }else{
            auth()->user()->tokens()->delete();
            return response()->json([
                'message' => "The access token has been deleted."
            ]);
        }
    }
}
