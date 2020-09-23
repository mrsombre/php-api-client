<?php

declare(strict_types=1);

namespace Example\Test;

use PHPUnit\Framework\TestCase;
use Example\Client;

class ClientTest extends TestCase
{
    public function testCreate()
    {
        Client::create();
        $this->expectNotToPerformAssertions();
    }
}
