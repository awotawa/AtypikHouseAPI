<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ApiResource(
  normalizationContext: ['groups' => ['user:read']],
  denormalizationContext: ['groups' => ['user:write']],
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'])]
#[ApiFilter(SearchFilter::class, properties: ['roles' => 'partial'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\NotBlank()]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\Regex(['pattern' => '/([A-Za-z0-9À-ÿ]+@[A-Za-z]+\.[A-Za-z]{2,5})/'])]
    #[Assert\Email()]
    #[Groups(["user:read", "user:write", "reservation:read"])]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[Assert\NotBlank()]
    #[Assert\Length([
      'min' => 8,
      'minMessage' => 'Your password must be at least {{ limit }} characters long',
    ])]
    #[Assert\Regex(['pattern' => "/^(?=.*[A-Z])(?=.*[\-._~!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/"])]
    #[ORM\Column(type: 'string')]
    #[Groups('user:write')]
    private $password;

    #[Assert\NotBlank()]
    #[Assert\Length([
      'min' => 2,
      'max' => 255,
      'minMessage' => 'Your first name must be at least {{ limit }} characters long',
      'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
      ])]
    #[Assert\Regex(['pattern'=>"/^([A-Za-zÀ-ÿ]+)$/"])]
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["user:read", "user:write"])]
    private $firstName;

    #[Assert\NotBlank()]
    #[Assert\Length([
      'min' => 2,
      'max' => 255,
      'minMessage' => 'Your last name must be at least {{ limit }} characters long',
      'maxMessage' => 'Your last name cannot be longer than {{ limit }} characters',
      ])]
    #[Assert\Regex(['pattern' => "/^([A-Za-zÀ-ÿ]+)$/"])]
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["user:read", "user:write"])]
    private $lastName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Regex(['pattern' => "/(https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&=]*))/"])]
    #[Groups(["user:read", "user:write"])]
    private $photo;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    private $updatedAt;

    #[ORM\OneToOne(mappedBy: 'userId', targetEntity: Owner::class, cascade: ['persist', 'remove'])]
    #[Groups(["user:read"])]
    private $owner;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Review::class, orphanRemoval: true)]
    #[Groups(["user:read"])]
    private $reviews;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Reservation::class)]
    #[Groups(["user:read"])]
    private $reservations;

    public function __construct()
    {
      $this->createdAt = new \DateTimeImmutable();
      $this->reviews = new ArrayCollection();
      $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

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

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): self
    {
        // set the owning side of the relation if necessary
        if ($owner->getUserId() !== $this) {
            $owner->setUserId($this);
        }

        $this->owner = $owner;

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
            $review->setUserId($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUserId() === $this) {
                $review->setUserId(null);
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
            $reservation->setUserId($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getUserId() === $this) {
                $reservation->setUserId(null);
            }
        }

        return $this;
    }
}
