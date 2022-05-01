<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MediaRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
  normalizationContext: ['groups' => ['media:read']],
  denormalizationContext: ['groups' => ['media:write']],
)]
#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["media:read", "media:write", "lodging:read"])]
    private $mediaType;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Regex(['pattern' => "/(https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&=]*))/"])]
    #[Groups(["media:read", "media:write", "lodging:read"])]
    private $link;

    #[ORM\ManyToOne(targetEntity: Lodging::class, inversedBy: 'media')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["media:read"])]
    private $lodgingId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMediaType(): ?string
    {
        return $this->mediaType;
    }

    public function setMediaType(string $mediaType): self
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

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
