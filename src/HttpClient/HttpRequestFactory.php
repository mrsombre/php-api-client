<?php

declare(strict_types=1);

namespace Example\HttpClient;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

class HttpRequestFactory implements HttpRequestFactoryInterface
{
    private Config $config;
    private ?RequestFactoryInterface $requestFactory;
    private ?StreamFactoryInterface $streamFactory;
    private ?UriFactoryInterface $uriFactory;

    public function __construct(
        Config $config,
        RequestFactoryInterface $requestFactory = null,
        StreamFactoryInterface $streamFactory = null,
        UriFactoryInterface $uriFactory = null
    ) {
        $this->config = $config;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->uriFactory = $uriFactory;
    }

    public function create(
        string $method,
        $uri,
        $body = null,
        array $headers = null
    ): RequestInterface {
        if (!$uri instanceof UriInterface) {
            $uri = $this->getUriFactory()->createUri($this->config->getEndpoint())
                ->withPath($uri);
        }
        $request = $this->getRequestFactory()->createRequest($method, $uri);
        if (is_string($body)) {
            $body = $this->getStreamFactory()->createStream($body);
            $request = $request->withBody($body);
        }
        if (is_array($headers)) {
            foreach ($headers as $name => $value) {
                $request = $request->withAddedHeader($name, $value);
            }
        }
        return $request;
    }

    private function getRequestFactory(): RequestFactoryInterface
    {
        if (null === $this->requestFactory) {
            $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        }
        return $this->requestFactory;
    }

    public function setRequestFactory(RequestFactoryInterface $requestFactory): self
    {
        $this->requestFactory = $requestFactory;
        return $this;
    }

    private function getStreamFactory(): StreamFactoryInterface
    {
        if (null === $this->streamFactory) {
            $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }
        return $this->streamFactory;
    }

    public function setStreamFactory(StreamFactoryInterface $streamFactory): self
    {
        $this->streamFactory = $streamFactory;
        return $this;
    }

    private function getUriFactory(): UriFactoryInterface
    {
        if (null === $this->uriFactory) {
            $this->uriFactory = Psr17FactoryDiscovery::findUrlFactory();
        }
        return $this->uriFactory;
    }

    public function setUriFactory(UriFactoryInterface $uriFactory): self
    {
        $this->uriFactory = $uriFactory;
        return $this;
    }
}
