<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PasswordResetCode;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset code
     */
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();
        $resetCode = PasswordResetCode::createForEmail($request->email);

        // Send email with code
        try {
            Mail::raw("Your password reset code is: {$resetCode->code}\n\nThis code will expire in 15 minutes.", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Password Reset Code - Mini Market');
            });

            return redirect()->route('password.verify', ['email' => $request->email])
                           ->with('status', 'A 6-digit reset code has been sent to your email.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send reset code. Please try again.']);
        }
    }

    /**
     * Show code verification form
     */
    public function showVerifyForm(Request $request)
    {
        $email = $request->get('email');
        
        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-code', compact('email'));
    }

    /**
     * Verify reset code and show password reset form
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6'
        ]);

        $resetCode = PasswordResetCode::findValidCode($request->email, $request->code);

        if (!$resetCode) {
            return back()->withErrors(['code' => 'Invalid or expired reset code.']);
        }

        return redirect()->route('password.reset', [
            'email' => $request->email,
            'code' => $request->code
        ]);
    }

    /**
     * Show password reset form
     */
    public function showResetForm(Request $request)
    {
        $email = $request->get('email');
        $code = $request->get('code');

        if (!$email || !$code) {
            return redirect()->route('password.request');
        }

        // Verify code is still valid
        $resetCode = PasswordResetCode::findValidCode($email, $code);
        if (!$resetCode) {
            return redirect()->route('password.request')
                           ->withErrors(['email' => 'Reset code has expired. Please request a new one.']);
        }

        return view('auth.reset-password', compact('email', 'code'));
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $resetCode = PasswordResetCode::findValidCode($request->email, $request->code);

        if (!$resetCode) {
            return back()->withErrors(['code' => 'Invalid or expired reset code.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Mark code as used
        $resetCode->markAsUsed();

        return redirect()->route('login')
                       ->with('status', 'Your password has been successfully reset. You can now log in with your new password.');
    }
}
