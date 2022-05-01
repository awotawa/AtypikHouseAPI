<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LodgingRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ApiResource(
  attributes: ["pagination_items_per_page" => 10],
  normalizationContext: ['groups' => ['lodging:read']],
  denormalizationContext: ['groups' => ['lodging:write']],
)]
#[ORM\Entity(repositoryClass: LodgingRepository::class)]
#[ApiFilter(SearchFilter::class, properties:['adress' => 'partial'])]
class Lodging
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\NotBlank()]
    #[Assert\Length([
      'min' => 2,
      'max' => 50,
      'minMessage' => 'The name must be at least {{ limit }} characters long',
      'maxMessage' => 'The name cannot be longer than {{ limit }} characters',
      ])]
    #[Assert\Regex(['pattern'=>"/^([A-Za-zÀ-ÿ '-]+)$/"])]
    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["lodging:read", "lodging:write"])]
    private $name;

    #[Assert\NotBlank()]
    #[Assert\Range([
        'min' => 0.01,
        'max' => 9999.99
    ])]
    #[Assert\Regex(['pattern' => "/^([0-9]+(\.[0-9]{0,2})?)$/"])]
    #[ORM\Column(type: 'float')]
    #[Groups(["lodging:read", "lodging:write"])]
    private $rate;

    #[Assert\NotBlank()]
    #[Assert\Length([
        'min' => 50,
        'max' => 255,
        'minMessage' => 'Your description must be at least {{ limit }} characters long',
        'maxMessage' => 'Your description cannot be longer than {{ limit }} characters',
    ])]
    #[Assert\Regex(['pattern' => "/^([A-Za-z0-9À-ÿ ',:?()~&\.-]+)$/"])]
    #[ORM\Column(type: 'text', length: 255)]
    #[Groups(["lodging:read", "lodging:write"])]
    private $lodgingDescription;

    #[Assert\NotBlank()]
    #[Assert\Length([
        'max' => 50,
        'maxMessage' => 'Your adress cannot be longer than {{ limit }} characters',
    ])]
    #[ORM\Column(type: 'text', length: 50)]
    #[Groups(["lodging:read", "lodging:write"])]
    private $adress;

    #[ORM\Column(type: 'time')]
    #[Groups(["lodging:read", "lodging:write"])]
    private $checkInTime;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    private $updatedAt;

    #[ORM\OneToMany(mappedBy: 'lodgingId', targetEntity: Review::class, orphanRemoval: true)]
    #[Groups(["lodging:read"])]
    private $reviews;

    #[ORM\OneToMany(mappedBy: 'lodgingId', targetEntity: Reservation::class)]
    #[Groups(["lodging:read"])]
    private $reservations;

    #[ORM\OneToMany(mappedBy: 'lodgingId', targetEntity: Media::class, orphanRemoval: true)]
    #[Groups(["lodging:read"])]
    private $media;

    #[ORM\ManyToOne(targetEntity: Owner::class, inversedBy: 'lodgings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["lodging:read"])]
    private $ownerId;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'lodgings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["lodging:read"])]
    private $categoryId;

    #[ORM\OneToMany(mappedBy: 'lodgingId', targetEntity: LodgingValue::class, orphanRemoval: true)]
    #[Groups(["lodging:read"])]
    private $lodgingValues;

    public function __construct()
    {
      $this->createdAt = new \DateTimeImmutable();
      $this->reviews = new ArrayCollection();
      $this->reservations = new ArrayCollection();
      $this->media = new ArrayCollection();
      $this->lodgingValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getLodgingDescription(): ?string
    {
        return $this->lodgingDescription;
    }

    public function setLodgingDescription(string $lodgingDescription): self
    {
        $this->lodgingDescription = $lodgingDescription;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCheckInTime(): ?\DateTimeInterface
    {
        return $this->checkInTime;
    }

    public function setCheckInTime(\DateTimeInterface $checkInTime): self
    {
        $this->checkInTime = $checkInTime;

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

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setLodgingId($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getLodgingId() === $this) {
                $review->setLodgingId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setLodgingId($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getLodgingId() === $this) {
                $reservation->setLodgingId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): self
    {
        if (!$this->media->contains($medium)) {
            $this->media[] = $medium;
            $medium->setLodgingId($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): self
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getLodgingId() === $this) {
                $medium->setLodgingId(null);
            }
        }

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

    public function getCategoryId(): ?Category
    {
        return $this->categoryId;
    }

    public function setCategoryId(?Category $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * @return Collection<int, LodgingValue>
     */
    public function getLodgingValues(): Collection
    {
        return $this->lodgingValues;
    }

    public function addLodgingValue(LodgingValue $lodgingValue): self
    {
        if (!$this->lodgingValues->contains($lodgingValue)) {
            $this->lodgingValues[] = $lodgingValue;
            $lodgingValue->setLodgingId($this);
        }

        return $this;
    }

    public function removeLodgingValue(LodgingValue $lodgingValue): self
    {
        if ($this->lodgingValues->removeElement($lodgingValue)) {
            // set the owning side to null (unless already changed)
            if ($lodgingValue->getLodgingId() === $this) {
                $lodgingValue->setLodgingId(null);
            }
        }

        return $this;
    }


}
