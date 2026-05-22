<?php

namespace App\Entity;

use App\Repository\EventRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;

#[ApiResource(
    operations: [
        new Get(security: "is_granted('ROLE_STAFF')"),
        new GetCollection(security: "is_granted('ROLE_STAFF')"),
        new Post(security: "is_granted('ROLE_STAFF')"),
        new Put(security: "is_granted('ROLE_STAFF')"),
        new Delete(security: "is_granted('ROLE_STAFF')"),
    ]
)]

#[ORM\Entity(repositoryClass: EventRequestRepository::class)]
#[ORM\Table(name: 'event_request')]
class EventRequest
{
    public const SOURCE_MOBILE = 'mobile_app';
    public const SOURCE_WEB = 'web';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $requestedBy = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Event type is required.')]
    private ?string $eventType = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $preferredDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $estimatedGuestCount = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $preferredVenue = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $theme = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $specialRequests = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $budget = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 50, options: ['default' => 'pending'])]
    private ?string $status = 'pending';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $adminNotes = null;

    #[ORM\Column(length: 32, options: ['default' => 'web'])]
    private string $source = self::SOURCE_WEB;

    #[ORM\ManyToOne(targetEntity: ServicePackage::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?ServicePackage $servicePackage = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $preferredTime = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $preferredStyleLabel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $preferredStyleImagePath = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->status = 'pending';
        $this->source = self::SOURCE_WEB;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequestedBy(): ?User
    {
        return $this->requestedBy;
    }

    public function setRequestedBy(?User $requestedBy): static
    {
        $this->requestedBy = $requestedBy;
        return $this;
    }

    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType): static
    {
        $this->eventType = $eventType;
        return $this;
    }

    public function getPreferredDate(): ?\DateTimeInterface
    {
        return $this->preferredDate;
    }

    public function setPreferredDate(?\DateTimeInterface $preferredDate): static
    {
        $this->preferredDate = $preferredDate;
        return $this;
    }

    public function getEstimatedGuestCount(): ?int
    {
        return $this->estimatedGuestCount;
    }

    public function setEstimatedGuestCount(?int $estimatedGuestCount): static
    {
        $this->estimatedGuestCount = $estimatedGuestCount;
        return $this;
    }

    public function getPreferredVenue(): ?string
    {
        return $this->preferredVenue;
    }

    public function setPreferredVenue(?string $preferredVenue): static
    {
        $this->preferredVenue = $preferredVenue;
        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): static
    {
        $this->theme = $theme;
        return $this;
    }

    public function getSpecialRequests(): ?string
    {
        return $this->specialRequests;
    }

    public function setSpecialRequests(?string $specialRequests): static
    {
        $this->specialRequests = $specialRequests;
        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(?string $budget): static
    {
        $this->budget = $budget;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getAdminNotes(): ?string
    {
        return $this->adminNotes;
    }

    public function setAdminNotes(?string $adminNotes): static
    {
        $this->adminNotes = $adminNotes;
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

    public function isFromMobileApp(): bool
    {
        return self::SOURCE_MOBILE === $this->source;
    }

    public function getServicePackage(): ?ServicePackage
    {
        return $this->servicePackage;
    }

    public function setServicePackage(?ServicePackage $servicePackage): static
    {
        $this->servicePackage = $servicePackage;

        return $this;
    }

    public function getPreferredTime(): ?string
    {
        return $this->preferredTime;
    }

    public function setPreferredTime(?string $preferredTime): static
    {
        $this->preferredTime = $preferredTime;

        return $this;
    }

    public function getPreferredStyleLabel(): ?string
    {
        return $this->preferredStyleLabel;
    }

    public function setPreferredStyleLabel(?string $preferredStyleLabel): static
    {
        $this->preferredStyleLabel = $preferredStyleLabel;

        return $this;
    }

    public function getPreferredStyleImagePath(): ?string
    {
        return $this->preferredStyleImagePath;
    }

    public function setPreferredStyleImagePath(?string $preferredStyleImagePath): static
    {
        $this->preferredStyleImagePath = $preferredStyleImagePath;

        return $this;
    }
}

