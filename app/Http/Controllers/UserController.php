<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{


    public function checkUser($id)
    {
        if($id>10){
            return response ()->json(['message'=>'User not found'],404);
        }
        else{
            return response ()->json(['message'=>'Ahlan we sahlan'],200);
        }
    }
    public function getprofile($id)
    {
        $profile = User::find($id)->profile;
        return response()->json($profile, 200);
}
    public function getUserTasks($id)
    {
        $tasks = User::find($id)->tasks;
        return response()->json($tasks, 200);
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    // جيب اليوزر من الداتابيز
    $user = User::where('email', $request->email)->first();

    // لو مش موجود أو الباسورد غلط
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    // إنشاء توكين جديد باستخدام sanctum
    $token = $user->createToken('auth_token')->plainTextToken;

    // رجّع التوكين مع اليوزر
    return response()->json([
        'message' => 'Login successful',
        'user' => $user,
        'token' => $token
    ], 200);

    }

    public function logout(Request $request)
    {
        // يمسح كل التوكينات الخاصة باليوزر الحالي
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // إنشاء التوكن
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'User registered successfully',
        'user' => $user,
        'token' => $token
    ], 201);
}

}