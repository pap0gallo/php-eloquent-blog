<?php

namespace App\Tests;

use App\Tests\TestCase;
use App\Library;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Review;
use App\Models\User;
use Exception;

class LibraryTest extends TestCase
{
    public function testGetAvailableBooks(): void
    {
        $book1 = Book::factory()->create(['copies_available' => 1]);
        $book2 = Book::factory()->create(['copies_available' => 1]);
        $book3 = Book::factory()->create(['copies_available' => 0]);


        $availableBooks = Library::getAvailableBooks();

        $this->assertTrue($availableBooks->contains($book1));
        $this->assertTrue($availableBooks->contains($book2));
        $this->assertFalse($availableBooks->contains($book3));

        $book1->copies_available = 0;
        $book1->save();

        $availableBooks = Library::getAvailableBooks();

        $this->assertFalse($availableBooks->contains($book1));
    }

    public function testBorrowAvailableBook(): void
    {
        $book = Book::factory()->create(['copies_available' => 2]);
        $user = User::factory()->create();

        $borrow = Library::borrowBook($user, $book);

        $book->refresh();

        $this->assertEquals(1, $book->copies_available);
        $this->assertNull($borrow->return_date);
    }

    public function testBorrowBookNoCopies(): void
    {
        $book = Book::factory()->create(['copies_available' => 0]);
        $user = User::factory()->create();

        $this->expectException(Exception::class);

        Library::borrowBook($user, $book);
    }

    public function testReturnBook(): void
    {

        $borrow = Borrow::factory()->create(['return_date' => null]);

        $updatedBorrow = Library::returnBook(
            $borrow->user,
            $borrow->book
        );

        $this->assertNotNull($updatedBorrow->return_date);
        $this->assertTrue($updatedBorrow->is($borrow));
    }

    public function testReturnBookNotBorrowed(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->expectException(Exception::class);

        Library::returnBook($user, $book);
    }

    public function testGetPopularBooks(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $book1 = Book::factory()->create(['copies_available' => 50]);
        $book2 = Book::factory()->create(['copies_available' => 50]);
        $book3 = Book::factory()->create(['copies_available' => 50]);


        Borrow::factory()->create(['book_id' => $book1->id, 'user_id' => $user1->id]);
        Borrow::factory()->create(['book_id' => $book2->id, 'user_id' => $user2->id]);
        Borrow::factory()->create(['book_id' => $book2->id, 'user_id' => $user1->id]);

        $popularBooks = Library::getPopularBooks();

        $this->assertCount(2, $popularBooks);
        $this->assertEquals($book2->id, $popularBooks[0]->id);
        $this->assertEquals($book1->id, $popularBooks[1]->id);
        $this->assertFalse($popularBooks->contains($book3));
    }

    public function testReview(): void
    {
        $book1 = Book::factory()->create();
        $user1 = User::factory()->create();

        Library::review($user1, $book1, 5);

        $reviewCreated = Review::where([
            'reviewer_id' => $user1->id,
            'book_id' => $book1->id,
            'rating' => 5,
        ])->exists();

        $this->assertTrue($reviewCreated);
    }

    public function testReviewInvalidRating(): void
    {
        $book1 = Book::factory()->create();
        $user1 = User::factory()->create();

        $this->expectException(Exception::class);

        Library::review($user1, $book1, 0);

        $reviewCreated = Review::where([
            'reviewer_id' => $user1->id,
            'book_id' => $book1->id,
            'rating' => 5,
        ])->exists();

        $this->assertFalse($reviewCreated);
    }

    public function testReviewInvalidRating2(): void
    {
        $book1 = Book::factory()->create();
        $user1 = User::factory()->create();

        $this->expectException(Exception::class);

        Library::review($user1, $book1, 6);

        $reviewCreated = Review::where([
            'reviewer_id' => $user1->id,
            'book_id' => $book1->id,
            'rating' => 6,
        ])->exists();

        $this->assertFalse($reviewCreated);
    }

    public function testGetTopRatedBooks(): void
    {
        $book1 = Book::factory()->create();
        $book2 = Book::factory()->create();


        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        Review::create(['book_id' => $book1->id, 'reviewer_id' => $user1->id, 'rating' => 5]);
        Review::create(['book_id' => $book1->id, 'reviewer_id' => $user2->id, 'rating' => 4]);
        Review::create(['book_id' => $book1->id, 'reviewer_id' => $user3->id, 'rating' => 3]);

        Review::create(['book_id' => $book2->id, 'reviewer_id' => $user1->id, 'rating' => 3]);
        Review::create(['book_id' => $book2->id, 'reviewer_id' => $user2->id, 'rating' => 2]);

        $topBooks = Library::getTopRatedBooks();

        $topBook = $topBooks->first();

        $this->assertCount(2, $topBooks);
        $this->assertEquals($book1->title, $topBook->title);
        $this->assertEquals(4.0, $topBook->reviews_avg_rating);
    }

    public function testSearchByTitle(): void
    {
        Book::factory()->create([
            'title' => 'Война и мир'
        ]);

        $secondBook = Book::factory()->create([
            'title' => 'Анна Каренина'
        ]);

        $books = Library::searchByTitle('Анна');

        $this->assertCount(1, $books);
        $this->assertEquals($secondBook->id, $books->first()->id);
    }
}
