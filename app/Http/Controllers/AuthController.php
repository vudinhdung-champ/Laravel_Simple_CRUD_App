<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{

    public function Register(Request $request) {
        $request->validate([
            'username' => ['required', 'min:3', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8']
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = Auth::guard('api')->login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Đăng ký tài khoản thành công',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]

        ], 201); 
    }


    public function Login(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('username', 'password');

        $token = Auth::guard('api')->attempt($credentials);

        if(!$token)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Đăng nhập thất bại, username hoặc password không đúng'
            ], 401);    
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đăng nhập thành công',
            'user' => Auth::guard('api')->user(),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ], 201);
    } 
    

    public function Logout(Request $request) {
        Auth::guard('api')->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Đăng xuất thành công'
        ]);

    }


    public function Refresh() {
        try
        {
            $newToken = Auth::guard('api')->refresh();

            return response()->json([
                'status' => 'success',
                'message' => 'Làm mới token thành công',
                'authorization' => [
                    'token' => $newToken,
                    'type' => 'bearer'
                ]
            ], 201);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Làm mới không thành công'
            ], 401);
        }
    }

}
