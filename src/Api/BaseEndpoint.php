<?php

declare(strict_types=1);

namespace Example\Api;

use Http\Client\HttpClient;
use Example\HttpClient\HttpRequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Example\Exception\ResponseException;

abstract class BaseEndpoint
{
    protected HttpClient $httpClient;
    protected HttpRequestFactoryInterface $requestFactory;
    protected SerializerInterface $serializer;

    public function __construct(
        HttpClient $httpClient,
        HttpRequestFactoryInterface $requestFactory,
        SerializerInterface $serializer = null
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        if ($serializer === null) {
            $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
            $encoders = [new JsonEncoder()];
            $serializer = new Serializer($normalizers, $encoders);
        }
        $this->serializer = $serializer;
    }

    protected function parseResponse(ResponseInterface $response): string
    {
        if ($response->getStatusCode() >= 400) {
            throw new ResponseException(
                sprintf(
                    'Got http response code %s with reason %s.',
                    $response->getStatusCode(),
                    $response->getReasonPhrase(),
                )
            );
        }

        if (0 !== strpos($response->getHeaderLine('Content-Type'), 'application/json')) {
            throw new ResponseException(
                sprintf(
                    'Invalid Content-Type: %s.',
                    $response->getHeaderLine('Content-Type'),
                )
            );
        }

        return $response->getBody()->__toString();
    }
}
