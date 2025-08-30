<?php

namespace App\config\schema;

use Illuminate\Database\Capsule\Manager as Capsule;

function load()
{
    if (!Capsule::schema()->hasTable('users')) {
        Capsule::schema()->create('users', function ($table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }
    if (!Capsule::schema()->hasTable('posts')) {
        Capsule::schema()->create('posts', function ($table) {
            $table->bigIncrements('id');
            $table->string('state');
            $table->string('title');
            $table->text('body');
            $table->integer('likes_count');
            $table->bigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->timestamps();
        });
    }
    if (!Capsule::schema()->hasTable('post_likes')) {
        Capsule::schema()->create('post_likes', function ($table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->bigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->timestamps();
        });
    }
}
