<?php

declare(strict_types=1);

namespace Example\HttpClient;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;

class HttpClientFactory implements HttpClientFactoryInterface
{
    private ?HttpClient $httpClient;

    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    public function create(): HttpClient
    {
        return $this->getHttpClient();
    }

    private function getHttpClient(): HttpClient
    {
        if ($this->httpClient === null) {
            $this->httpClient = HttpClientDiscovery::find();
        }
        return $this->httpClient;
    }

    public function setHttpClient(HttpClient $httpClient): self
    {
        $this->httpClient = $httpClient;
        return $this;
    }
}
