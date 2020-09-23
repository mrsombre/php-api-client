<?php

declare(strict_types=1);

namespace Example\HttpClient;

class Config
{
    private string $endpoint = 'https://example.com';

    public function __construct(string $endpoint = null)
    {
        if ($endpoint !== null) {
            $this->endpoint = $endpoint;
        }
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function setEndpoint(string $endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }
}
