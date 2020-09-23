<?php

declare(strict_types=1);

namespace Example;

use Example\HttpClient\Config;
use Example\HttpClient\HttpClientFactory;
use Example\HttpClient\HttpClientFactoryInterface;
use Example\HttpClient\HttpRequestFactory;
use Example\HttpClient\HttpRequestFactoryInterface;
use Http\Client\HttpClient;

final class Client
{
    private HttpClient $httpClient;
    private HttpRequestFactoryInterface $requestFactory;

    public static function create(string $endpoint = null): Client
    {
        $config = new Config($endpoint);
        return new self(
            new HttpClientFactory(),
            new HttpRequestFactory($config),
        );
    }

    public function __construct(
        HttpClientFactoryInterface $httpClientFactory,
        HttpRequestFactoryInterface $requestFactory
    ) {
        $this->httpClient = $httpClientFactory->create();
        $this->requestFactory = $requestFactory;
    }

    public function comments(): Api\Comments
    {
        return new Api\Comments(
            $this->httpClient,
            $this->requestFactory,
        );
    }
}
