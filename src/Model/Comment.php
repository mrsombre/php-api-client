<?php

declare(strict_types=1);

namespace Example\Model;

class Comment
{
    private ?int $id;
    private ?string $name;
    private ?string $text;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $text = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->text = $text;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }
}
