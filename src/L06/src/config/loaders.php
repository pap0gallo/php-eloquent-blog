<?php

namespace App\config\loaders;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

function bootstrap()
{
    $capsule = new Capsule();
    $capsule->addConnection([
        'driver'    => 'pgsql',
        'database'  => 'tirion',
        'username'  => 'tirion',
        'password'  => 'secret',
        /* 'charset'   => 'utf8', */
        /* 'collation' => 'utf8_unicode_ci', */
        /* 'prefix'    => '', */
    ]);
    // Make this Capsule instance available globally via static methods... (optional)
    $capsule->setAsGlobal();

    $capsule->setEventDispatcher(new Dispatcher(new Container()));

    // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
    $capsule->bootEloquent();

    $capsule->connection()->listen(function ($query) {
        echo "\n";
        var_dump($query->sql);
    });

    return ['capsule' => $capsule];
}

function loadSeeds()
{
    \App\Models\User::factory()->create();
    \App\Models\Post::factory()->create();
    \App\Models\PostLike::factory()->create();
    \App\Models\PostComment::factory()->create();
}
