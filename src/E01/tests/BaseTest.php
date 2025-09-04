<?php

namespace App\Tests;

use App\Config\Loaders;
use PHPUnit\Framework\TestCase;

use function App\Config\Schema\load;

abstract class BaseTest extends TestCase
{
    protected $capsule;

    public function setUp(): void
    {
        ['capsule' => $this->capsule] = loaders\bootstrap();

        load();

        $this->capsule->getConnection()->beginTransaction();
    }

    public function tearDown(): void
    {
        $this->capsule->getConnection()->rollback();
    }
}
