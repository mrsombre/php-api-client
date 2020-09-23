<?php

declare(strict_types=1);

namespace Example\Test\HttpClient;

use PHPUnit\Framework\TestCase;
use Example\HttpClient\HttpClientFactory;

class HttpClientFactoryTest extends TestCase
{
    public function testDefaults()
    {
        $factory = new HttpClientFactory();

        $factory->create();
        $this->expectNotToPerformAssertions();
    }
}
