<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReviewRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
  normalizationContext: ['groups' => ['review:read']],
  denormalizationContext: ['groups' => ['review:write']],
)]
#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\Range([
        'min' => 1,
        'max' => 10,
    ])]
    #[Assert\Regex(['pattern' => "/^([1-9]|10)$/"])]
    #[ORM\Column(type: 'integer', length: 10)]
    #[Groups(["review:read", "review:write"])]
    private $rating;

    #[Assert\Length([
        'max' => 100,
        'maxMessage' => 'Your review title cannot be longer than {{ limit }} characters',
    ])]
    #[Assert\Regex(['pattern'=>"/^([A-Za-zÀ-ÿ '!-]+)$/"])]
    #[ORM\Column(type: 'text', length: 100)]
    #[Groups(["review:read", "review:write"])]
    private $reviewTitle;

    #[Assert\Length([
        'max' => 255,
        'maxMessage' => 'Your review description cannot be longer than {{ limit }} characters',
    ])]
    #[Assert\Regex(['pattern'=>"/^([A-Za-zÀ-ÿ '!-]+)$/"])]
    #[ORM\Column(type: 'text', length: 255)]
    #[Groups(["review:read", "review:write"])]
    private $reviewDescription;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: Owner::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["review:read"])]
    private $ownerId;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["review:read"])]
    private $userId;

    #[ORM\ManyToOne(targetEntity: Lodging::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["review:read"])]
    private $lodgingId;

    public function __construct()
    {
      $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getReviewTitle(): ?string
    {
        return $this->reviewTitle;
    }

    public function setReviewTitle(string $reviewTitle): self
    {
        $this->reviewTitle = $reviewTitle;

        return $this;
    }

    public function getReviewDescription(): ?string
    {
        return $this->reviewDescription;
    }

    public function setReviewDescription(string $reviewDescription): self
    {
        $this->reviewDescription = $reviewDescription;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getOwnerId(): ?Owner
    {
        return $this->ownerId;
    }

    public function setOwnerId(?Owner $ownerId): self
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getLodgingId(): ?Lodging
    {
        return $this->lodgingId;
    }

    public function setLodgingId(?Lodging $lodgingId): self
    {
        $this->lodgingId = $lodgingId;

        return $this;
    }
}
