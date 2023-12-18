<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/user",
     *     tags={"User"},
     *     summary="Create a new user",
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *        mediaType="application/json",
     *        @OA\Schema(
     *          @OA\Property(
     *             property="name",
     *             description="Name of the user.",
     *             type="string",
     *           ),
     *          @OA\Property(
     *            property="email",
     *            description="Email address of the user.",
     *            type="string",
     *          ),
     *          @OA\Property(
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

    /**
     * @OA\Get(
     *     path="/api/user/logs",
     *     summary="Get user audit log",
     *     security={{"bearer_token":{}}},
     *     tags={"User"},
     *     @OA\Parameter(
     *        in="query",
     *        required=true,
     *        name="email",
     *        description="User's e-mail address",
     *        @OA\Schema(
     *          type="string"
     *       ),
     *    ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function logs(Request $request, UserService $userService)
    {
        $email = $request->input('email');
        return $userService->logs($email);
    }
}
