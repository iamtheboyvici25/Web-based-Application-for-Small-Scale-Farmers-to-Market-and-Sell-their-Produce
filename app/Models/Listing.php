<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    // 1. Allow these fields to be saved to the database
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'quantity',
        'unit',
    ];

    // 2. Create the relationship: A Listing Belongs To a User (Farmer)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}