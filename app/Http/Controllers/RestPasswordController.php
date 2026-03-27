<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class RestPasswordController extends Controller
{
    public function Change_Password(Request $request) {
        $request->validate([
            'email' => 'required'
        ]);

        $checkValid = User::where('email', $request->email)->exists();

        if(!$checkValid)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Email chưa được đăng ký với hệ thống'
            ], 401);
        }

        DB::table('password_reset_tokens')->where('email',  $request->email)->delete();

        $token = Str::random(30);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()

        ]);

        $resetLink = "http://localhost:5173/reset-password?token=" . $token . "&email=" . $request->email;

        Mail::raw("Xin chào!\n\nĐể đổi mật khẩu, vui lòng click vào đường link sau:\n" . $resetLink . "\n\nNếu bạn không yêu cầu, vui lòng bỏ qua thư này.", function ($message) use ($request)
        {
            $message->to($request->email)->subject('Yêu cầu khôi phục mật khẩu');
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Đã gửi link khôi phục mật khẩu vào email của bạn'
        ], 200);

    }

    public function Reset_Password(Request $request) {
        $request->validate([
            'email' => 'required',
            'token' => 'required',
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $isValid = DB::table('password_reset_tokens')->where('email', $request->email)
                                                     ->where('token', $request->token)
                                                     ->exists();

        if(!$isValid)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi không đúng email hoặc token'
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if($user)
        {
            $user->password = Hash::make($request->password);

            $user->save();

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        }

        return response()->json([
            'status' => 'success',
            'message' => 'Đổi mật khẩu thành công! Vui lòng đăng nhập lại'

        ], 200);

        return view('/login');
    }

}
