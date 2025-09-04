<?php

namespace App\Config\Schema;

use Illuminate\Database\Capsule\Manager as Capsule;

function load(): void
{
    $tables = [
        'reviews',
        'borrows',
        'books',
        'users',
    ];

    foreach ($tables as $table) {
        if (Capsule::schema()->hasTable($table)) {
            Capsule::schema()->drop($table);
        }
    }

    Capsule::schema()->create('books', function ($table) {
        $table->bigIncrements('id');
        $table->string('title');
        $table->string('author');
        $table->string('genre');
        $table->integer('copies_available')->default(0);
        $table->timestamps();
    });

    Capsule::schema()->create('users', function ($table) {
        $table->bigIncrements('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password_hash');
        $table->timestamps();
    });

    Capsule::schema()->create('borrows', function ($table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('book_id');
        $table->unsignedBigInteger('user_id');
        $table->date('borrow_date');
        $table->date('return_date')->nullable();
        $table->timestamps();

        $table->foreign('book_id')->references('id')->on('books');
        $table->foreign('user_id')->references('id')->on('users');
    });

    Capsule::schema()->create('reviews', function ($table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('book_id');
        $table->string('reviewer_id');
        $table->integer('rating');
        $table->timestamps();

        $table->foreign('book_id')->references('id')->on('books');
    });
}
