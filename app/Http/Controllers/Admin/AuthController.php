<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminOtpMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Login Form
    public function showlogin()
    {
        return view('admin.auth.screens.login');
    }

    // Login Logic
    public function doLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:admins,username',
            'password' => 'required|min:6',
        ]);
        $credentials = $request->only('username', 'password');
        if (auth()->guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['username' => 'Invalid credentials']);
    }

    // Logout
    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }

    // Forgot Password Form
    public function showForgotPasswordForm()
    {
        return view('admin.auth.screens.forgot-password');
    }

    // Forgot Password Logic
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);
        $admin = Admin::where('email', $request->email)->first();
        $otp = rand(100000, 999999);
        session(['otp' => $otp, 'email' => $request->email]);
        Cache::put('reset_otp_'.$request->email, $otp, now()->addMinutes(5));
        Mail::to($admin->email)->send(new AdminOtpMail($otp, $admin->name));

        return redirect()->route('admin.otp-verification')->with('success', 'OTP sent to your email.');
    }

    // Otp Verification Form
    public function showOtpVerificationForm()
    {
        return view('admin.auth.screens.otp-verification');
    }

    // Otp Verification Logic
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);
        $email = session('email');
        if (! $email) {
            return back()->withErrors(['otp' => 'Session expired. Please request a new OTP.']);
        }
        $otp = $request->input('otp');
        if (Cache::get('reset_otp_'.$email) == $otp) {
            session(['verified_email' => $email]);

            return redirect()->route('admin.reset-password');
        }

        return back()->withErrors(['otp' => 'Invalid OTP or OTP expired.']);
    }

    // Reset Password Form
    public function showResetPasswordForm()
    {
        if (! session('verified_email')) {
            return redirect()->route('admin.forgot-password')->withErrors(['error' => 'Unauthorized access!']);
        }

        return view('admin.auth.screens.reset-password');
    }

    // Reset Password Logic
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);
        $email = session('verified_email');
        if (! $email) {
            return redirect()->route('admin.forgot-password')->withErrors(['error' => 'Unauthorized access!']);
        }
        $admin = Admin::where('email', $email)->first();
        $admin->password = Hash::make($request->input('password'));
        $admin->save();
        session()->forget(['otp', 'email', 'verified_email']);
        Cache::forget('reset_otp_'.$email);

        return redirect()->route('admin.login')->with('success', 'Password reset successfully.');
    }

    // Show Change Profile Form
    public function changeProfile()
    {
        $admin = auth()->guard('admin')->user();

        return view('admin.auth.screens.profile', compact('admin'));
    }

    // Save Profile Changes
    public function changeProfileSave(Request $request)
    {
        /** @var Admin $admin */
        $admin = auth()->guard('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username,'.$admin->id,
            'email' => 'required|email|max:255|unique:admins,email,'.$admin->id,
        ]);
        // Update admin details
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->save();
        // Log out if email changed to ensure re-authentication
        if ($admin->email !== $request->email) {
            Auth::guard('admin')->logout();

            return redirect()->route('admin.login')->with('success', 'Profile updated successfully. Please login with your new credentials.');
        }

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
}
