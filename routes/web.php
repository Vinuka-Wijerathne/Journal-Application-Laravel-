<?php

use App\Http\Controllers\WelcomeController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request; // Import Request class
use Illuminate\Support\Facades\Auth; // Import Auth class
use App\Models\User; // Import User model

Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Protect the dashboard route with auth middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


// routes/web.php


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/journal/create', [JournalController::class, 'create'])->name('journal.create');
    Route::post('/journal', [JournalController::class, 'store'])->name('journal.store');
    Route::get('/journal/edit/{id}', [JournalController::class, 'edit'])->name('journal.edit');
    Route::put('/journal/update/{id}', [JournalController::class, 'update'])->name('journal.update');

});


// Profile route
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

// Authentication routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.post');

// Password reset routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Email verification notice route
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

// Email verification route
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    // Find the user by ID
    $user = User::findOrFail($id);

    // Check if the hash matches the user's email
    if (!hash_equals($hash, sha1($user->email))) {
        return redirect('/')->with('error', 'Email verification failed.');
    }

    // Mark the user as verified
    $user->markEmailAsVerified();

    // Log the user in (optional)
    Auth::login($user);

    return redirect('/')->with('success', 'Email verified successfully!');
})->middleware(['signed'])->name('verification.verify');
