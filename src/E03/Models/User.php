<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function borrowedBooks(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'borrows');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
