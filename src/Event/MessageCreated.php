<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class MessageCreated extends Event
{
    private \DateTimeImmutable $createdAt;

    public function __construct(
        private readonly  string $uuid
    )
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
