<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OwnerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
  normalizationContext: ['groups' => ['owner:read']],
)]
#[ORM\Entity(repositoryClass: OwnerRepository::class)]
class Owner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["owner:read"])]
    private $id;

    #[ORM\OneToOne(inversedBy: 'owner', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["owner:read"])]
    private $userId;

    #[ORM\OneToMany(mappedBy: 'ownerId', targetEntity: Review::class, orphanRemoval: true)]
    #[Groups(["owner:read"])]
    private $reviews;

    #[ORM\OneToMany(mappedBy: 'ownerId', targetEntity: Lodging::class, orphanRemoval: true)]
    #[Groups(["owner:read"])]
    private $lodgings;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->lodgings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(User $userId): self
    {
        $this->userId = $userId;

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
            $review->setOwnerId($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getOwnerId() === $this) {
                $review->setOwnerId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lodging>
     */
    public function getLodgings(): Collection
    {
        return $this->lodgings;
    }

    public function addLodging(Lodging $lodging): self
    {
        if (!$this->lodgings->contains($lodging)) {
            $this->lodgings[] = $lodging;
            $lodging->setOwnerId($this);
        }

        return $this;
    }

    public function removeLodging(Lodging $lodging): self
    {
        if ($this->lodgings->removeElement($lodging)) {
            // set the owning side to null (unless already changed)
            if ($lodging->getOwnerId() === $this) {
                $lodging->setOwnerId(null);
            }
        }

        return $this;
    }
}
