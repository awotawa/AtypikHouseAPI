<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReservationRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
  normalizationContext: ['groups' => ['reservation:read']],
  denormalizationContext: ['groups' => ['reservation:write']],
)]
#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(["reservation:read", "reservation:write"])]
    private $price;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["reservation:read", "reservation:write"])]
    private $startDate;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["reservation:read", "reservation:write"])]
    private $endDate;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["reservation:read", "reservation:write"])]
    private $paid;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["reservation:read"])]
    private $userId;

    #[ORM\ManyToOne(targetEntity: Lodging::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["reservation:read"])]
    private $lodgingId;

    public function __construct()
    {
      $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): self
    {
        $this->paid = $paid;

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
