<?php

namespace App\Config\Loaders;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

function bootstrap(): array
{
    $capsule = new Capsule();
    $capsule->addConnection([
        'driver'    => 'pgsql',
        'database'  => 'tirion',
        'username'  => 'tirion',
        'password'  => 'secret',
    ]);
    $capsule->setAsGlobal();

    $capsule->setEventDispatcher(new Dispatcher(new Container()));

    $capsule->bootEloquent();

    $capsule->connection()->listen(function ($query) {
        // echo "\n";
        // var_dump($query->sql);
    });

    return ['capsule' => $capsule];
}

function loadSeeds(): void
{
}
