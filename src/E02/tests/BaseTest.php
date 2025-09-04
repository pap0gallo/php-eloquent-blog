<?php

namespace App\Tests;

use App\Config\Loaders;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected $capsule;

    public function setUp(): void
    {
        ['capsule' => $this->capsule] = loaders\bootstrap();

        $this->capsule->getConnection()->beginTransaction();
    }

    public function tearDown(): void
    {
        $this->capsule->getConnection()->rollback();
    }
}
