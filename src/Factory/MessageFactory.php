<?php

namespace App\Factory;

use App\Entity\Message;
use Symfony\Component\Uid\Uuid;

class MessageFactory
{
    public function createWithText(string $text): Message
    {
        $message = new Message();
        $message->setUuid(Uuid::v6()->toRfc4122());
        $message->setText($text);

        return $message;
    }
}