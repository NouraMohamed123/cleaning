<?php

namespace App\Http\Controllers\AppUser;

use App\Http\Controllers\Controller;
use App\Models\AppUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class appAuthController extends Controller
{

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (!$token = JWTAuth::attempt($credentials)) {
    //         return response()->json([
    //             'message' => 'Invalid email or password',
    //         ], 401);
    //     }
    //     $user = Auth::guard('app_users')->user();
    //     $id = $user->id;
    //     $name = $user->name;


    //     return response()->json([
    //         'access_token' => $token,
    //         "name" => $name,
    //         "id" => $id,
    //         'expires_in' => JWTAuth::factory()->getTTL() * 60,
    //     ]);
    // }
    public function login(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }

        // Attempt to authenticate the user using the credentials and the 'AppUsers' guard
        if (!$token = Auth::guard('app_users')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }
        $user = Auth::guard('app_users')->user();
        Auth::guard('app_users')->user()->update(['device_token'=>$request->device_token]);
        $id = $user->id;
        $name = $user->name;
        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'access_token' => $token,
            "name" => $name,
            "id" => $id,
            'expires_in' => JWTAuth::factory()->getTTL() * 100,
        ]);
    }





    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:app_users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }

        $user = AppUsers::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message' => 'عملية تسجيل الخروج تمت بنجاح'
        ]);
    }
}
