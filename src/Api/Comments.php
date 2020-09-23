<?php

declare(strict_types=1);

namespace Example\Api;

use Example\Model\Comment;
use InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class Comments extends BaseEndpoint
{
    /**
     * @return Comment[]
     */
    public function getList(): array
    {
        $request = $this->requestFactory->create(
            'GET',
            '/comments',
        );
        $response = $this->httpClient->sendRequest($request);

        $data = $this->parseResponse($response);
        return $this->serializer->deserialize($data, '\Example\Model\Comment[]', 'json');
    }

    public function create(Comment $comment): void
    {
        $request = $this->requestFactory->create(
            'POST',
            '/comment',
            $this->serializer->serialize($comment, 'json')
        );
        $response = $this->httpClient->sendRequest($request);

        $data = $this->parseResponse($response);
        $this->serializer->deserialize($data, Comment::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $comment]);
    }

    public function update(Comment $comment): void
    {
        if ($comment->getId() === null) {
            throw new InvalidArgumentException("Only comments with valid ID can be updated.");
        }

        $request = $this->requestFactory->create(
            'PUT',
            "/comment/{$comment->getId()}",
            $this->serializer->serialize($comment, 'json')
        );
        $response = $this->httpClient->sendRequest($request);

        $data = $this->parseResponse($response);
        $this->serializer->deserialize($data, Comment::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $comment]);
    }
}
