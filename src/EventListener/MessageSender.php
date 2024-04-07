<?php

namespace App\EventListener;

use App\Entity\Message;
use App\Enum\MessageStatus;
use App\Event\MessageCreated;
use App\Factory\ChannelSpecificMessageFactory;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class MessageSender
{

    public function __construct(
        private readonly MessageRepository $repository,
        private readonly ChannelSpecificMessageFactory $channelSpecificMessageFactory,
        private readonly MessageBusInterface $messageBus,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function __invoke(MessageCreated $event): void
    {
        /** @var Message $message */
        $message = $this->repository->find($event->getUuid());
        if (!($message instanceof Message)) {
            throw new InvalidArgumentException('no entity found');
        }
        $this->sendMessage($message);
        $this->updateStatus($message);

        // here should be MessageSent dispatched, theoretically. But as no Service is defined that listens to it, i let it be.
        // this service could do some logging or other stuff to keep track of the events.
    }

    /**
     * @param Message $message
     * @return void
     */
    public function sendMessage(Message $message): void
    {
        $channelMessage = $this->channelSpecificMessageFactory->create($message);
        $this->messageBus->dispatch($channelMessage);
    }

    /**
     * @param Message $message
     * @return void
     */
    public function updateStatus(Message $message): void
    {
        $message->setStatus(MessageStatus::SENT);

        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }


}