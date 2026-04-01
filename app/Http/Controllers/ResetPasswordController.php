<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\ResetPasswordMail;
use App\Http\Requests\StoreResetPasswordRequest;
use App\Notifications\ResetPasswordNotification;


class ResetPasswordController extends Controller
{
    public function changePassword(Request $request) {
        $request->validate([
            'email' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user)
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

        $user->notify(new ResetPasswordNotification($token)); 


        return response()->json([
            'status' => 'success',
            'message' => 'Đã gửi link khôi phục mật khẩu vào email của bạn'
        ], 200);

    }

    public function resetPassword(StoreResetPasswordRequest $request) {

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
