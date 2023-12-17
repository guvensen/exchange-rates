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

    public function logs($email)
    {
        $user = User::with('logs')->where('email', $email)->first();
        $i = 0;
        $logs = [];

        if(!$user){
            return response()->json([
                'message' => "User not found."
            ], 404);
        }

        foreach ($user->logs as $log){
            $logs[$i]['log_type'] = $log->log_type;
            $logs[$i]['endpoint'] = $log->endpoint;
            $logs[$i]['ip'] = $log->ip;
            $logs[$i]['created_at'] = $log->created_at;
            $i++;
        }

        return response()->json($logs);
    }
}
