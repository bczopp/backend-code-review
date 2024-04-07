<?php

namespace App\CQ\Command;

readonly class SendMessage
{
    public function __construct(
        private string $text
    ){
    }

    public function getText(): string
    {
        return $this->text;
    }
}