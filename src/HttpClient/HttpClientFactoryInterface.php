<?php

declare(strict_types=1);

namespace Example\HttpClient;

use Http\Client\HttpClient;

interface HttpClientFactoryInterface
{
    public function create(): HttpClient;
}
