<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // untuk menampilkan form email
    public function showEmailForm()
    {
        return view('auth.forgot-password.forgot-password-email');
    }

    // Step 2: Proses email dan kirim OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak ditemukan dalam sistem.'
        ]);

        $email = $request->email;
        $otp = rand(100000, 999999); // Generate 6 digit OTP

        // Hapus OTP lama jika ada
        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();

        // Simpan OTP ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => Hash::make($otp), // Hash OTP untuk keamanan
            'created_at' => Carbon::now()
        ]);

        // Kirim email dengan OTP
        try {
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Kode OTP Reset Password');
            });

            return redirect()
                ->route('password.otp-form', ['email' => base64_encode($email)])
                ->with('success', 'Kode OTP telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }

    // Step 3: Show form untuk input OTP
    public function showOtpForm($email)
    {
        $email = base64_decode($email);

        // Cek apakah ada OTP yang valid
        $otpExists = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('created_at', '>', Carbon::now()->subMinutes(10)) // OTP valid 10 menit
            ->exists();

        if (!$otpExists) {
            return redirect()->route('password.request')
                ->with('error', 'Kode OTP tidak valid atau sudah kadaluarsa.');
        }

        return view('auth.forgot-password.verify-otp', compact('email'));
    }

    // Step 4: Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6'
        ]);

        $email = $request->email;
        $otp = $request->otp;

        // Ambil token dari database
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('created_at', '>', Carbon::now()->subMinutes(10))
            ->first();

        if (!$passwordReset || !Hash::check($otp, $passwordReset->token)) {
            return back()->with('error', 'Kode OTP salah atau sudah kadaluarsa.');
        }

        // OTP benar, arahkan ke form reset password
        return redirect()
            ->route('password.reset-form', ['email' => base64_encode($email), 'token' => base64_encode($otp)])
            ->with('success', 'Kode OTP benar. Silakan masukkan password baru.');
    }

    // Step 5: Show form reset password
    public function showResetForm($email, $token)
    {
        $email = base64_decode($email);
        $otp = base64_decode($token);

        // Verifikasi sekali lagi
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('created_at', '>', Carbon::now()->subMinutes(10))
            ->first();

        if (!$passwordReset || !Hash::check($otp, $passwordReset->token)) {
            return redirect()->route('password.request')
                ->with('error', 'Link reset password tidak valid.');
        }

        return view('auth.forgot-password.reset-password', compact('email'));
    }

    // Step 6: Update password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $email = $request->email;

        // Cek apakah masih ada token yang valid
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('created_at', '>', Carbon::now()->subMinutes(10))
            ->first();

        if (!$passwordReset) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi reset password sudah berakhir.');
        }

        // Update password user
        User::where('email', $email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus token setelah berhasil reset
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $email = $request->email;

        // Cek apakah email valid
        if (!User::where('email', $email)->exists()) {
            return response()->json(['error' => 'Email tidak valid'], 400);
        }

        $otp = rand(100000, 999999);

        // Update atau insert OTP baru
        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['email' => $email],
                [
                    'token' => Hash::make($otp),
                    'created_at' => Carbon::now()
                ]
            );

        // Kirim email
        try {
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Kode OTP Reset Password - Kirim Ulang');
            });

            return response()->json(['success' => 'Kode OTP baru telah dikirim']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengirim email'], 500);
        }
    }
}
