<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ORM\Table(name: 'payment')]
#[ORM\UniqueConstraint(name: 'UNIQ_PAYMENT_RECEIPT', fields: ['receiptNumber'])]
#[ORM\UniqueConstraint(name: 'UNIQ_PAYMENT_EVENT_REQUEST', fields: ['eventRequest'])]
#[ORM\Index(columns: ['user_id'], name: 'idx_payment_user')]
#[ORM\Index(columns: ['created_at'], name: 'idx_payment_created_at')]
class Payment
{
    public const SOURCE_MOBILE = 'mobile_app';
    public const SOURCE_WEB = 'web';

    public const STATUS_APPROVED = 'approved';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\OneToOne(inversedBy: 'paymentTransaction', targetEntity: EventRequest::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?EventRequest $eventRequest = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(length: 3, options: ['default' => 'PHP'])]
    private string $currency = 'PHP';

    #[ORM\Column(length: 40)]
    private ?string $receiptNumber = null;

    #[ORM\Column(length: 32, options: ['default' => 'mobile_app'])]
    private string $source = self::SOURCE_MOBILE;

    #[ORM\Column(length: 20, options: ['default' => 'approved'])]
    private string $status = self::STATUS_APPROVED;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getEventRequest(): ?EventRequest
    {
        return $this->eventRequest;
    }

    public function setEventRequest(?EventRequest $eventRequest): static
    {
        if ($eventRequest && $eventRequest->getPaymentTransaction() !== $this) {
            $eventRequest->setPaymentTransaction($this);
        }

        $this->eventRequest = $eventRequest;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getReceiptNumber(): ?string
    {
        return $this->receiptNumber;
    }

    public function setReceiptNumber(string $receiptNumber): static
    {
        $this->receiptNumber = $receiptNumber;

        return $this;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getSourceLabel(): string
    {
        return match ($this->source) {
            self::SOURCE_MOBILE => 'Mobile app',
            default => 'Website',
        };
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
