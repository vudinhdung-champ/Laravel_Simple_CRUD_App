<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 24px; }
        h2 { color: #4f46e5; }
        .info-box { background: #f0f4ff; border-left: 4px solid #4f46e5; padding: 12px 16px; border-radius: 4px; margin: 16px 0; }
        .footer { margin-top: 32px; font-size: 13px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Xin chào {{ $userName }}! 👋</h2>
        <p>File Excel tổng hợp dữ liệu của bạn đã được xuất thành công và đính kèm trong email này.</p>

        <div class="info-box">
            📊 File <strong>du_lieu_cua_toi.xlsx</strong> bao gồm 3 sheet:
            <ul>
                <li><strong>Đăng ký dịch vụ</strong> — danh sách các subscription</li>
                <li><strong>Lời hứa</strong> — danh sách các promise</li>
                <li><strong>Ghi chú</strong> — danh sách các notebook</li>
            </ul>
        </div>

        <p>Vui lòng mở file bằng Microsoft Excel hoặc Google Sheets.</p>

        <div class="footer">
            Trân trọng,<br>
            <strong>Laravel CRUD App</strong>
        </div>
    </div>
</body>
</html>
