<?php

declare(strict_types=1);

namespace Example\Test\HttpClient;

use Example\HttpClient\Config;
use PHPUnit\Framework\TestCase;
use Example\HttpClient\HttpRequestFactory;

class HttpRequestFactoryTest extends TestCase
{
    public function testDefaults()
    {
        $config = new Config('http://test.com');
        $factory = new HttpRequestFactory($config);

        $request = $factory->create('POST', '/testpath');

        $this->assertSame('test.com', $request->getUri()->getHost());
        $this->assertSame('/testpath', $request->getUri()->getPath());
        $this->assertSame('POST', $request->getMethod());
    }
}
