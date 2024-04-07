<?php

namespace App\CQ\CommandHandler;

use App\CQ\Command\SendMessage;
use App\Entity\Message;
use App\Event\MessageCreated;
use App\Factory\MessageFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SendMessageHandler
{
    public function __construct(
        private readonly MessageFactory $factory,
        private readonly MessageBusInterface $messageBus,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function handle(SendMessage $request): void
    {
        // well, that's obvious, create Message and dispatch
        // depending on the config, this one should be dispatched asynchronously
        $message = $this->createMessage($request->getText());
        $this->messageBus->dispatch(new MessageCreated($message->getUuid()));
    }

    private function createMessage(string $text): Message
    {
        // not sure about this one. i could also put the item in the event, dispatch and save, once the status is set in another handler.
        // but saving it now is a bit more fail safe.
        $message = $this->factory->createWithText($text);
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return $message;
    }
}