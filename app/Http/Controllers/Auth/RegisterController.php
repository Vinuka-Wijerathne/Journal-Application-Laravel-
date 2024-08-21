<?php

// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use App\Notifications\VerifyEmailNotification;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Update this to your view's correct path
    }

    public function register(Request $request)
{
    Log::info('Registration attempt:', $request->all());

    try {
        // Validate the incoming request data
        $this->validator($request->all())->validate();
        Log::info('Validation passed');

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Log::info('User created: ' . $user->email);

        // Fire the registered event
        event(new Registered($user));

        // Send the custom verification email
        $user->sendEmailVerificationNotification();

        // Redirect to the verification notice page with Lottie animation
        return redirect()->route('verification.notice')->with('success', 'Registration successful! Please verify your email.');
        
    } catch (ValidationException $e) {
        Log::error('Validation error: ', $e->errors());
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        Log::error('Registration failed: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'User registration failed. Please try again.'])->withInput();
    }
}


    // Validate the registration data
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
