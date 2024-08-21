<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt to log the user in
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user(); // Get the authenticated user

            // Check if the user's email is verified
            if (!$user->hasVerifiedEmail()) { // Change here
                Auth::logout(); // Log out the user if the email is not verified
                return back()->withErrors([
                    'email' => 'Your email address is not verified. Please check your email for the verification link.',
                ]);
            }

            return redirect()->intended('journal.dashboard'); // Redirect to intended route if verified
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
