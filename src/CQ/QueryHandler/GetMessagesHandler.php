<?php

namespace App\CQ\QueryHandler;

use App\CQ\Query\GetMessages;
use App\Entity\Message;
use App\Repository\MessageRepository;

class GetMessagesHandler
{
    public function __construct(
        private readonly MessageRepository $repository,
    )
    {
    }

    /**
     * @param GetMessages $request
     * @return array<array<string, string|null>>
     */
    public function handle(GetMessages $request): array
    {
        // get messages from repo, transform and return. quite easy
        return array_map(
            fn(Message $message) => $this->createMessageInfo($message),
            $this->repository->findBy($this->getWhere($request))
        );
    }

    /**
     * @param GetMessages $request
     * @return array<string, string>|array{}
     */
    private function getWhere(GetMessages $request): array
    {
        // i don't like that, to be honest.
        // but it's a difference if it's an empty $where or a $where with an empty value for 'status'
        $where = [];
        if (0 < strlen($request->getStatus())) {
            // += in combination with arrays would not override an already existing 'status' in $where,
            // not important here but still worth to mention i thought
            $where += ['status' => $request->getStatus()];
        }
        return $where;
    }

    /**
     * @param Message $message
     * @return array<string, string|null>
     */
    private function createMessageInfo(Message $message): array
    {
        // theoretically here should a new event be thrown to set status to 'read', i guess
        return [
            'uuid' => $message->getUuid(),
            'text' => $message->getText(),
            'status' => $message->getStatus()?->value,
        ];
    }
}