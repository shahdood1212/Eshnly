<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    // ✅ تسجيل مستخدم جديد
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 422);
        }

        // ✅ رفع الصورة إذا تم تقديمها
        $imagePath = $request->hasFile('user_image') ? $request->file('user_image')->store('users', 'public') : null;

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // 🔹 تأكد من تشفير كلمة المرور
                'user_image' => $imagePath,
            ]);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ], 201);

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    // ✅ تسجيل الدخول وإرجاع التوكن
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated(); // 🔹 استخدم `LoginRequest` للتحقق من البيانات

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Invalid credentials'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    // ✅ استرجاع بيانات المستخدم الحالي
    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
        // ✅ تسجيل الخروج
        public function logout()
        {
            try {
                JWTAuth::parseToken()->invalidate();
                return response()->json(['message' => 'Successfully logged out']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
        
        public function refresh()
        {
            try {
                $newToken = JWTAuth::parseToken()->refresh();
                return response()->json([
                    'access_token' => $newToken,
                    'token_type' => 'bearer',
                    'expires_in' => auth('api')->factory()->getTTL() * 60
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
        
    // ✅ تنسيق استجابة التوكن
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
