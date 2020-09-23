<?php

declare(strict_types=1);

namespace Example\Test\Api;

use Example\HttpClient\HttpRequestFactoryInterface;
use Http\Client\HttpClient;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function createHttpClient(
        $data,
        int $responseCode = null
    ): HttpClient {
        if ($responseCode === null) {
            $responseCode = 200;
        }

        $mock = $this->getMockBuilder(HttpClient::class)
            ->onlyMethods(['sendRequest'])
            ->getMock();

        $mock
            ->expects($this->any())
            ->method('sendRequest')
            ->willReturn(
                new Response(
                    $responseCode,
                    ['Content-Type' => 'application/json'],
                    json_encode($data)
                )
            );

        return $mock;
    }

    protected function createRequestFactory(
        string $method,
        string $uri
    ): HttpRequestFactoryInterface {
        $mock = $this->getMockBuilder(HttpRequestFactoryInterface::class)
            ->onlyMethods(['create'])
            ->getMock();
        $mock
            ->expects($this->once())
            ->method('create')
            ->with($method, $uri)
            ->willReturn(new Request($method, $uri));

        return $mock;
    }
}
