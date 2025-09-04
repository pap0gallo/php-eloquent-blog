<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Topic extends Model
{
    use HasFactory;

    // BEGIN (write your solution here)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // END
}
