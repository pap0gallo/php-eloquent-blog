<?php

namespace App;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;

class Library
{
    public static function getBooks(): Collection
    {
        return Book::all();
    }

    public static function searchByTitle(string $subtitle): Collection
    {
        // BEGIN (write your solution here)
        return Book::where('title', 'like', "%".$subtitle."%")->get();

        // END
    }

    public static function getAvailableBooks(): Collection
    {
        return Book::available()->get();
    }

    public static function getPopularBooks(): Collection
    {
        return Book::popular()->get();
    }

    public static function getTopRatedBooks(): Collection
    {
        return Book::topRated()->get();
    }

    public static function review(User $author, Book $book, int $rating): Review
    {
        // BEGIN (write your solution here)
        if ($rating > 0 && $rating < 6) {
            return Review::updateOrCreate(
                [
                    'book_id' => $book->id,
                    'reviewer_id' => $author->id
                ],
                [
                    'rating' => $rating
                ]
            );
        }
        throw new \InvalidArgumentException('review');
        // END
    }

    public static function borrowBook(User $user, Book $book): Borrow
    {
        // BEGIN (write your solution here)
        $bookAvailability = $book->copies_available;
        if ($bookAvailability > 0) {
            $book->decrement('copies_available', 1);
            $borrow = Borrow::make();
            $borrow->borrow_date = date('Y-m-d H:i:s');
            $borrow->user()->associate($user);
            $borrow->book()->associate($book);
            $borrow->save();
            return $borrow;
        }
        throw new \Exception('bb');
        // END
    }

    public static function returnBook(User $user, Book $book): Borrow
    {
        // BEGIN (write your solution here)
        $borrow = Borrow::where('book_id', $book->id)
            ->where(['user_id' => $user->id, 'book_id' => $book->id])
            ->whereNull('return_date')
            ->first();

        if (! $borrow) {
            throw new \Exception('return');
        }

        $book->increment('copies_available', 1);

        $borrow->update([
            'return_date' => date('Y-m-d H:i:s'),
        ]);

        return $borrow;
        // END
    }
}
