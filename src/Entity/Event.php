<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use App\Entity\Venue;
use App\Entity\ServicePackage;
use App\Entity\User;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;

#[ApiResource(
    operations: [
        new Get(security: "is_granted('ROLE_USER')"),
        new GetCollection(security: "is_granted('ROLE_USER')"),
        new Post(security: "is_granted('ROLE_STAFF')"),
        new Put(security: "is_granted('ROLE_STAFF')"),
        new Delete(security: "is_granted('ROLE_STAFF')"),
    ]
)]

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Customer name is required.')]
    private ?string $customerName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Event type is required.')]
    private ?string $eventType = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Assert\NotBlank(message: 'Event date is required.')]
    #[Assert\Type(type: \DateTimeImmutable::class, message: 'Please enter a valid date and time.')]
    private ?\DateTimeImmutable $eventDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $venue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $theme = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero(message: 'Guest count cannot be negative.')]
    private ?int $guestCount = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Price is required.')]
    #[Assert\PositiveOrZero(message: 'Price must be zero or greater.')]
    private ?float $price = null;

    // Relationships
    #[ORM\ManyToOne(targetEntity: Venue::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Venue $venueRef = null;

    #[ORM\ManyToOne(targetEntity: ServicePackage::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?ServicePackage $package = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $createdBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setCustomerName(string $customerName): static
    {
        $this->customerName = $customerName;

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

    public function getEventDate(): ?\DateTimeImmutable
    {
        return $this->eventDate;
    }

    public function setEventDate(?\DateTimeImmutable $eventDate): static
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getVenue(): ?string
    {
        return $this->venue;
    }

    public function setVenue(?string $venue): static
    {
        $this->venue = $venue;

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

    public function getGuestCount(): ?int
    {
        return $this->guestCount;
    }

    public function setGuestCount(?int $guestCount): static
    {
        $this->guestCount = $guestCount;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getVenueRef(): ?Venue
    {
        return $this->venueRef;
    }

    public function setVenueRef(?Venue $venueRef): static
    {
        $this->venueRef = $venueRef;
        return $this;
    }

    public function getPackage(): ?ServicePackage
    {
        return $this->package;
    }

    public function setPackage(?ServicePackage $package): static
    {
        $this->package = $package;
        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;
        return $this;
    }
}
