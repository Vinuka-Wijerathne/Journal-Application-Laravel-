<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Import the MustVerifyEmail interface
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\JournalEntry; // Ensure this is imported

class User extends Authenticatable implements MustVerifyEmail // Implement the MustVerifyEmail interface
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Define the relationship to journal entries
    public function journalEntries(): HasMany
    {
        return $this->hasMany(JournalEntry::class);
    }

    // Add the hasVerifiedEmail method to your User model
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }
}
