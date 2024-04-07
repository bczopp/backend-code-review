<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Enum\MessageStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        // looks much cleaner that way, as it is much easier to test if it's know how many messages of which status exist
        $this->create(4, MessageStatus::CREATED, $manager);
        $this->create(3, MessageStatus::SENT, $manager);
        $this->create(3, MessageStatus::READ, $manager);

        $manager->flush();
    }

    private function create(int $amount, MessageStatus $status, ObjectManager $manager): void
    {
        foreach (range(1, $amount) as $i) {
            $message = new Message();
            $message->setUuid(Uuid::v6()->toRfc4122());
            $message->setText($this->faker->sentence);
            $message->setStatus($status);

            $manager->persist($message);
        }
    }
}
