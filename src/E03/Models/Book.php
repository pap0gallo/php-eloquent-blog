<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'genre', 'copies_available'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function borrowers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'borrows');
    }

    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // BEGIN (write your solution here)
    public static function available()
    {
        return self::where('copies_available', '>', 0);
    }

    public static function popular()
    {
        return self::withCount('borrows')
            ->has('borrows')
            ->orderByDesc('borrows_count');
    }

    public static function topRated()
    {
        return self::has('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(10);
    }
    // END
}
