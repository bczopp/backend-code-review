<?php

namespace App\Factory;

use App\Entity\Message;
use Symfony\Component\Notifier\Message\ChatMessage;

class ChannelSpecificMessageFactory
{
    // at latest here must be decided, which channel to take for sending message
    // as nothing is known so far, ChatMassage will be default for now
    public function create(Message $message): object
    {
        return new ChatMessage($message->getText());
    }
}