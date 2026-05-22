<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
#[ORM\Table(name: 'theme', uniqueConstraints: [
    new ORM\UniqueConstraint(name: 'uniq_theme_name_type', columns: ['name', 'event_type'])
])]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'Theme name is required.')]
    #[Assert\Length(max: 150)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'event_type', length: 50, nullable: true)]
    #[Assert\NotBlank]
    private ?string $eventType = null; // 'Birthday' or 'Wedding'

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $createdBy = null;

    /** @var list<string>|null Relative paths under public/ (e.g. uploads/theme-samples/…) */
    #[ORM\Column(name: 'sample_image_paths', type: 'json', nullable: true)]
    private ?array $sampleImagePaths = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /** @return list<string> */
    public function getSampleImagePaths(): array
    {
        if (!is_array($this->sampleImagePaths)) {
            return [];
        }

        return array_values(array_filter(
            $this->sampleImagePaths,
            static fn ($path) => is_string($path) && $path !== '',
        ));
    }

    /** @param list<string>|null $sampleImagePaths */
    public function setSampleImagePaths(?array $sampleImagePaths): static
    {
        $this->sampleImagePaths = $sampleImagePaths === null
            ? null
            : array_values(array_filter($sampleImagePaths, static fn ($p) => is_string($p) && $p !== ''));

        return $this;
    }

    public function __toString(): string
    {
        return (string)($this->name ?? '');
    }
}
