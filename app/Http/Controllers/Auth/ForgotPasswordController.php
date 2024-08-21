<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\PasswordResetLinkRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        return $response === Password::RESET_LINK_SENT
            ? back()->with('status', __('We have emailed your password reset link!'))
            : back()->withErrors(['email' => __('We can\'t find a user with that email address.')]);
    }
}