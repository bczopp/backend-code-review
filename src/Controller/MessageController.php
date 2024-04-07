<?php
declare(strict_types=1);

namespace App\Controller;

use App\CQ\Command\SendMessage;
use App\CQ\CommandHandler\SendMessageHandler;
use App\CQ\Query\GetMessages;
use App\CQ\QueryHandler\GetMessagesHandler;
use Controller\MessageControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @see MessageControllerTest
 * TODO: review both methods and also the `openapi.yaml` specification
 *       Add Comments for your Code-Review, so that the developer can understand why changes are needed.
 */

/**
 * starting at SingleResponsibility and CQRS approach this class needed to be refactored completely,
 * as almost the whole project. I added some new directories, classes, an enum, moved responsibilities ...
 * now the controller only calls a handler and takes care of the response. easy going
 *
 * Query- and Command-Handler and corresponding DTO can be found in src/CQ
 * from there i took the event-driven approach for SendMessage as it should be processed asynchronously.
 * GetMessages on the other hand must be processed synchronously as the caller is actively waiting for that response.
 *
 * i also required one or the other new helpful composer package.
 *
 * i only created unit test for one class.
 * should be a good representative. and doing it for all classes would be too much to ask for....
 */

class MessageController extends AbstractController
{
    public function __construct(
        private SendMessageHandler $sendMessageHandler,
        private GetMessagesHandler $getMessagesHandler,
    )
    {
    }

    /**
     * TODO: cover this method with tests, and refactor the code (including other files that need to be refactored)
     *
     * see comment above the class
     */
    #[Route('/messages')]
    public function list(Request $request): Response
    {
        return new Response(json_encode([
            'messages' => $this->getMessagesHandler->handle(
                new GetMessages(\strval($request->query->get('status') ?? ''))
            ),
        ], JSON_THROW_ON_ERROR), headers: ['Content-Type' => 'application/json']);
    }

    // of course this must be a POST route
    // and i could not not refactor this method......
    #[Route('/messages/send', methods: ['POST'])]
    public function send(Request $request): Response
    {
        $text = $request->request->get('text');
        
        if (!$text) {
            return new Response('Text is required', 400);
        }

        $this->sendMessageHandler->handle(new SendMessage(\strval($text)));
        
        return new Response('Successfully sent', 204);
    }
}