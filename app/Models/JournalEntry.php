<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalEntry extends Model
{
    protected $fillable = [
        'user_id', // Ensure this column exists in the database
        'content',
        'date', // Ensure this field exists in your database
    ];

    protected $casts = [
        'date' => 'datetime', // Cast the date to a Carbon instance
    ];

    // Define the inverse relationship to User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship to comments
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
