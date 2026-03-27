<!DOCTYPE html>
<html>
<head>
    <title>Khôi phục mật khẩu</title>
</head>
<body>
    <h2>Xin chào!</h2>
    <p>Bạn nhận được email này vì chúng tôi nhận được yêu cầu khôi phục mật khẩu cho tài khoản của bạn.</p>
    
    @php
        $resetLink = "http://localhost:3000/reset-password?token=" . $token . "&email=" . $email;
    @endphp

    <a href="{{ $resetLink }}" style="padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
        Đổi Mật Khẩu Ngay
    </a>

    <p>Nếu bạn không yêu cầu đổi mật khẩu, vui lòng bỏ qua email này.</p>
</body>
</html>