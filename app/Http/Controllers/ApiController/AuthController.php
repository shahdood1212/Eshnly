<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['user' => $user, 'token' => $token], 201);
   
    //     Log::info('Register Request Data:', $request->all());

    // $validated = Validator::make($request->all(), [
    //     'name' => 'required|string|max:255',
    //     'email' => 'required|string|email|max:255|unique:users',
    //     'password' => 'required|string|min:6|confirmed',
    //     'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    // ]);

    // if ($validated->fails()) {
    //     return response()->json(['errors' => $validated->errors()], 422);
    // }
    

    // $imagePath = null;
    // if ($request->hasFile('user_image')) {
    //     $imagePath = $request->file('user_image')->store('users', 'public');
    // }

    // try {
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'user_image' => $imagePath,
    //     ]);

    //     Log::info('User Created Successfully:', ['user_id' => $user->id]);

    //     $token = JWTAuth::fromUser($user);

    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'user' => $user
    //     ], 201);

    // } catch (\Exception $exception) {
    //     Log::error('Error Creating User:', ['message' => $exception->getMessage()]);
    //     return response()->json(['error' => $exception->getMessage()], 500);
    // }
}

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['token' => $token]);
    
        // try {
        //     $credentials = $request->only('email', 'password');

        //     if (!$token = JWTAuth::attempt($credentials)) {
        //         return response()->json(['error' => 'Unauthorized'], 401);
        //     }

        //     return $this->respondWithToken($token);

        // } catch (\Exception $e) {
        //     \Log::error('Login Error:', ['message' => $e->getMessage()]);
        //     return response()->json(['error' => 'Something went wrong'], 500);
        // }
    }


    public function me()
{
    try {
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Token is invalid'], 401);
    }
}


    public function logout()
    {
    
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
       
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}