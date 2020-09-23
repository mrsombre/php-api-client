<?php

declare(strict_types=1);

namespace Example\Test\Api;

use Example\Api\Comments;
use Example\Model\Comment;

class CommentsTest extends BaseTestCase
{
    public function testGetList()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'name1',
                'text' => 'text1',
            ],
        ];

        $httpClient = $this->createHttpClient($data);
        $requestFactory = $this->createRequestFactory('GET', '/comments');

        $comments = new Comments($httpClient, $requestFactory);
        $result = $comments->getList();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Comment::class, $result[0]);
    }

    public function testCreate()
    {
        $comment = new Comment();
        $comment->setName('tester');
        $comment->setText('sometext');

        $httpClient = $this->createHttpClient(['id' => 1, 'name' => 'tester', 'text' => 'sometext']);
        $requestFactory = $this->createRequestFactory('POST', '/comment');

        $comments = new Comments($httpClient, $requestFactory);
        $comments->create($comment);

        $this->assertSame(1, $comment->getId());
    }

    public function testUpdate()
    {
        $comment = new Comment(1, 'tester', 'sometext');

        $httpClient = $this->createHttpClient(['id' => 1, 'name' => 'tester', 'text' => 'sometext']);
        $requestFactory = $this->createRequestFactory('PUT', '/comment/1');

        $comments = new Comments($httpClient, $requestFactory);
        $comments->update($comment);

        $this->assertSame(1, $comment->getId());
    }
}
