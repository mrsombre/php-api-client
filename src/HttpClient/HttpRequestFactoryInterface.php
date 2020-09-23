<?php

declare(strict_types=1);

namespace Example\HttpClient;

use Psr\Http\Message\RequestInterface;

interface HttpRequestFactoryInterface
{
    public function create(
        string $method,
        $uri,
        $body = null,
        array $headers = null
    ): RequestInterface;
}
