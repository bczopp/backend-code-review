<?php
declare(strict_types=1);

namespace App\Tests\integration;

use App\DataFixtures\AppFixtures;
use App\Event\MessageCreated;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Notifier\Message\ChatMessage;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Messenger\Test\InteractsWithMessenger;
use function Safe\json_decode;

class MessageControllerTest extends WebTestCase
{
    use InteractsWithMessenger, ResetDatabase;

    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
    }


    function test_list_all(): void
    {
        $this->loadFixtures();

        $this->client->request('GET', '/messages');

        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $decoded = json_decode(\strval($response->getContent()), true);
        $this->assertIsArray($decoded);

        $this->assertCount(10, $decoded['messages']);
    }

    function test_list_with_status(): void
    {
        $this->loadFixtures();

        $this->client->request('GET', '/messages',['status'=>'sent']);

        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $decoded = json_decode(\strval($response->getContent()), true);
        $this->assertIsArray($decoded);

        $this->assertCount(3, $decoded['messages']);
    }
    
    function test_that_it_sends_a_message(): void
    {
        $this->client->request('POST', '/messages/send', [
            'text' => 'Hello World',
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(204);

        $async = $this->transport('async');
        $async->process(1);

        // it's actually totally fine to just check, if specific messages have been dispatched. just those and just once.
        foreach([MessageCreated::class, ChatMessage::class] as $expectedClass){
            $this->bus()->dispatched()->assertContains($expectedClass, 1);
        }
    }

    protected function loadFixtures(): void
    {
        // load fixtures. there must be an easier way as well.
        /** @var Registry $doctrine */
        $doctrine = self::$kernel?->getContainer()->get('doctrine');
        (new AppFixtures)->load($doctrine->getManager());
    }
}