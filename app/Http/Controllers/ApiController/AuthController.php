<?php
namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\Ship;
use App\Models\Trip;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
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

        $imagePath = $request->hasFile('user_image') ? $request->file('user_image')->store('users', 'public') : null;

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
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

    // ✅ تسجيل الدخول وإرجاع التوكن مع نوع المستخدم
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = auth('api')->user();

        // تحديد نوع المستخدم (client أو user)
        $userType = Client::where('user_id', $user->id)->exists() ? 'client' : 'user';

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user_type' => $userType
        ]);
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

    // ✅ تجديد التوكن
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

    // ✅ جلب جميع العملاء (متاح فقط لـ users)
    public function getAllClients()
    {
        $user = auth('api')->user();

        if ($user->type === 'user') {
            return response()->json(['error' => 'Access denied, read-only user'], 403);
        }

        $clients = Client::all();
        return response()->json($clients);
    }

    // ✅ جلب جميع السفن (متاح للجميع، لكن فقط clients يمكنهم الإضافة والتعديل)
    public function getAllShips()
    {
        $user = auth('api')->user();

        if ($user->type === 'user') {
            return response()->json(['error' => 'Access denied, read-only user'], 403);
        }

        return response()->json(Ship::all());
    }

    // ✅ جلب جميع الرحلات (متاح للجميع، لكن فقط clients يمكنهم الإضافة والتعديل)
    public function getAllTrips()
    {
        $user = auth('api')->user();

        if ($user->type === 'user') {
            return response()->json(['error' => 'Access denied, read-only user'], 403);
        }

        return response()->json(Trip::all());
    }

    // ✅ جلب جميع الحجوزات (متاح للجميع، لكن فقط clients يمكنهم الإضافة والتعديل)
    public function getAllBookings()
    {
        $user = auth('api')->user();

        if ($user->type === 'user') {
            return response()->json(['error' => 'Access denied, read-only user'], 403);
        }

        return response()->json(Booking::all());
    }
}
