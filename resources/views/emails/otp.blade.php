<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .otp-container {
            text-align: center;
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
            border: 2px dashed #007bff;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #007bff;
            letter-spacing: 8px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .warning-icon {
            color: #856404;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Reset Password</h1>
            <p>Kode verifikasi untuk reset password Anda</p>
        </div>
        
        <div class="content">
            <p>Halo,</p>
            <p>Anda telah meminta untuk reset password akun Anda. Gunakan kode OTP berikut untuk melanjutkan proses reset password:</p>
            
            <div class="otp-container">
                <p style="margin: 0; font-size: 14px; color: #666;">Kode OTP Anda:</p>
                <div class="otp-code">{{ $otp }}</div>
                <p style="margin: 0; font-size: 12px; color: #999;">Kode ini valid selama 10 menit</p>
            </div>
            
            <div class="warning">
                <p><span class="warning-icon">⚠️ Peringatan Keamanan:</span></p>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Kode OTP ini bersifat rahasia, jangan bagikan kepada siapa pun</li>
                    <li>Kode hanya valid selama 10 menit setelah email ini dikirim</li>
                    <li>Jika Anda tidak meminta reset password, abaikan email ini</li>
                    <li>Untuk keamanan, segera ganti password setelah berhasil login</li>
                </ul>
            </div>
            
            <p>Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan memasukkan kode OTP secara manual pada halaman verifikasi.</p>
            
            <p>Jika Anda tidak meminta reset password, silakan abaikan email ini atau hubungi administrator jika Anda merasa akun Anda dalam bahaya.</p>
            
            <p>Terima kasih,<br>
            <strong>Tim Support</strong></p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon jangan membalas email ini.</p>
            <p>© {{ date('Y') }} Aplikasi Anda. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
