<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'listing_id',
        'sender_id',
        'receiver_id',
        'message',
    ];

    // The listing this message belongs to
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    // The user who sent the message
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // The user who receives the message
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
