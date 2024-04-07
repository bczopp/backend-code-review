<?php

namespace App\CQ\Query;

readonly class GetMessages
{
    public function __construct(
        private ?string $status = null
    )
    {
    }

    public function getStatus(): string
    {
        return \strval($this->status);
    }
}