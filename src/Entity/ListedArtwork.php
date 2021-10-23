<?php

namespace App\Entity;

use App\Repository\ListedArtworkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListedArtworkRepository::class)
 */
class ListedArtwork
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Artwork::class, inversedBy="listedArtworks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artwork;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="listedArtworks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $seen;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtwork(): ?Artwork
    {
        return $this->artwork;
    }

    public function setArtwork(?Artwork $artwork): self
    {
        $this->artwork = $artwork;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSeen(): ?bool
    {
        return $this->seen;
    }

    public function setSeen(bool $seen): self
    {
        $this->seen = $seen;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }
}
