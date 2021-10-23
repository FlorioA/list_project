<?php

namespace App\Entity;

use App\Repository\ArtworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtworkRepository::class)
 */
class Artwork
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=Author::class, mappedBy="artworks")
     */
    private $authors;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validated;

    /**
     * @ORM\ManyToMany(targetEntity=Media::class, mappedBy="artworks")
     */
    private $medias;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="artworks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ListedArtwork::class, mappedBy="artwork", orphanRemoval=true)
     */
    private $listedArtworks;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->medias = new ArrayCollection();
        $this->listedArtworks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Author[]
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
            $author->addArtwork($this);
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        if ($this->authors->removeElement($author)) {
            $author->removeArtwork($this);
        }

        return $this;
    }

    public function getValidated(): ?\DateTimeInterface
    {
        return $this->validated;
    }

    public function setValidated(?\DateTimeInterface $validated): self
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->addArtwork($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->removeElement($media)) {
            $media->removeArtwork($this);
        }

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

    /**
     * @return Collection|ListedArtwork[]
     */
    public function getListedArtworks(): Collection
    {
        return $this->listedArtworks;
    }

    public function addListedArtwork(ListedArtwork $listedArtwork): self
    {
        if (!$this->listedArtworks->contains($listedArtwork)) {
            $this->listedArtworks[] = $listedArtwork;
            $listedArtwork->setArtwork($this);
        }

        return $this;
    }

    public function removeListedArtwork(ListedArtwork $listedArtwork): self
    {
        if ($this->listedArtworks->removeElement($listedArtwork)) {
            // set the owning side to null (unless already changed)
            if ($listedArtwork->getArtwork() === $this) {
                $listedArtwork->setArtwork(null);
            }
        }

        return $this;
    }
}
