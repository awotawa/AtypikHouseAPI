<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LodgingValueRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
  normalizationContext: ['groups' => ['lodgingvalue:read']],
  denormalizationContext: ['groups' => ['lodgingvalue:write']],
)]
#[ORM\Entity(repositoryClass: LodgingValueRepository::class)]
class LodgingValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\Length([
        'max' => 10,
        'maxMessage' => 'Your value cannot be longer than {{ limit }} characters',
    ])]
    #[Assert\Regex(['pattern'=>"/^([A-Za-z]+)$/"])]
    #[ORM\Column(type: 'string', length: 10)]
    #[Groups(["lodgingvalue:read", "lodgingvalue:write", "property:read"])]
    private $value;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: Lodging::class, inversedBy: 'lodgingValues')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["lodgingvalue:read"])]
    private $lodgingId;

    #[ORM\ManyToOne(targetEntity: Property::class, inversedBy: 'lodgingValues')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["lodgingvalue:read"])]
    private $propertyId;

    public function __construct()
    {
      $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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

    public function getLodgingId(): ?Lodging
    {
        return $this->lodgingId;
    }

    public function setLodgingId(?Lodging $lodgingId): self
    {
        $this->lodgingId = $lodgingId;

        return $this;
    }

    public function getPropertyId(): ?Property
    {
        return $this->propertyId;
    }

    public function setPropertyId(?Property $propertyId): self
    {
        $this->propertyId = $propertyId;

        return $this;
    }
}
