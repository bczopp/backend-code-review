<?php

namespace App\Tests\unit;

use App\Controller\MessageController;
use App\CQ\CommandHandler\SendMessageHandler;
use App\CQ\QueryHandler\GetMessagesHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class MessageControllerTest extends TestCase
{
    private MessageController $controller;
    private SendMessageHandler&MockObject $sendMessageHandler;
    private GetMessagesHandler&MockObject $getMessagesHandler;

    public function setUp(): void
    {
        $this->sendMessageHandler = $this->createMock(SendMessageHandler::class);
        $this->getMessagesHandler = $this->createMock(GetMessagesHandler::class);
        $this->controller = new MessageController($this->sendMessageHandler,$this->getMessagesHandler);
    }

    public function testList(): void
    {
        $this->getMessagesHandler->method('handle')
            ->willReturn([]);

        $response = $this->controller->list(new Request());

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('{"messages":[]}', \strval($response->getContent()));
    }

    public function testSendReturns400(): void
    {
        $this->sendMessageHandler->expects($this->never())
            ->method('handle');

        $response = $this->controller->send(new Request());
        $this->assertSame(400, $response->getStatusCode());
    }

    public function testSendReturns204(): void
    {
        $this->sendMessageHandler->expects($this->once())
            ->method('handle');

        $response = $this->controller->send(new Request(request:['text'=>'test']));
        $this->assertSame(204, $response->getStatusCode());
    }
}