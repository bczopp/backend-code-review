<?php

namespace App\Entity;

use App\Enum\MessageStatus;
use App\Repository\MessageRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
/**
 * TODO: Review Message class
 */
class Message
{
    // well, the only reason why i let this id stay how it is, is because i manually set $uuid and need it to identify the message.
    // maybe it would be better to send the message object within the events instead of just the id...
    // else i would prefer to use CustomIdGenerator to have Type Uuid as main Id and get rid of this auto-incremental stuff

    // and yes i know, it's not the best idea to ignore a phpstan notice.
    // but it's also annoying to have a getter that nobody uses, so i choose to not have a getter
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /** @phpstan-ignore-next-line */
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;

    // 255 chars seem a bit low. at least for an email for example. Type Text should fix that problem.
    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    // using enum
    #[ORM\Column(length: 255, nullable: true, enumType: MessageStatus::class)]
    private ?MessageStatus $status = null;

    // will now be set automatically when object is constructed
    #[ORM\Column(type: 'datetime', nullable:true)]
    private DateTime $createdAt;

    // new attribute. needed because different parameters can be set at different times.
    // also it is set automatically when an attribute is set. a developer does not have to remember while working with the object
    #[ORM\Column(type: 'datetime', nullable:true)]
    private DateTime $updatedAt;

    public function __construct()
    {
        $this->setCreatedAt();
    }

    public function getUuid(): string
    {
        Assert::notEmpty($this->uuid);

        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;
        $this->setUpdatedAt();

        return $this;
    }

    public function getText(): string
    {
        return \strval($this->text);
    }

    public function setText(string $text): static
    {
        $this->text = $text;
        $this->setUpdatedAt();

        return $this;
    }

    public function getStatus(): ?MessageStatus
    {
        return $this->status;
    }

    public function setStatus(MessageStatus $status): static
    {
        $this->status = $status;
        $this->setUpdatedAt();

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    private function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
        $this->setUpdatedAt();
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    private function setUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }
}
