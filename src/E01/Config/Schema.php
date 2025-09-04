<?php

namespace App\Config\Schema;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

function load(): void
{
    $tables = [
        'categories',
        'products',
    ];

    foreach ($tables as $table) {
        if (Capsule::schema()->hasTable($table)) {
            Capsule::schema()->drop($table);
        }
    }

    Capsule::schema()->create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });

    Capsule::schema()->create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->foreignId('category_id');
        $table->boolean('is_sponsored')->default(false);
        $table->timestamps();
    });
}
