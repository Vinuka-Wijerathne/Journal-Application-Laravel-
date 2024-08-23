<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\JournalEntry;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar', // Ensure this field is included
        'bio',    // Ensure this field is included
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

    // Define the followers relationship
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
    }

    // Define the following relationship
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id');
    }

    // Add the isFollowing method to check if the user is following another user
    public function isFollowing($userId): bool
    {
        return $this->following()->where('following_id', $userId)->exists();
    }

    // Add the hasVerifiedEmail method to your User model
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }
}
