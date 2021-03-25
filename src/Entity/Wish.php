<?php

namespace App\Entity;

use App\Repository\WishRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WishRepository::class)
 * @UniqueEntity("title", message="Ce titre est déjà utilisé.")
 */
class Wish
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Le champ Titre est obligatoire.")
     * @Assert\Length(
     *     min=2,
     *     max=250,
     *     minMessage="Minimum 2 caractères s'il vous plait.",
     *     maxMessage="Maximum 250 caractères s'il vous plait."
     * )
     * @ORM\Column(type="string", length=250)
     */
    private $title;

    /**
     * @Assert\Length(
     *     min=2,
     *     max=2000,
     *     minMessage="Minimum 2 caractères s'il vous plait.",
     *     maxMessage="Maximum 2 000 caractères s'il vous plait."
     * )
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @Assert\NotBlank(message="Le champ Auteur est obligatoire.")
     * @Assert\Length(
     *     min=2,
     *     max=50,
     *     minMessage="Minimum 2 caractères s'il vous plait.",
     *     maxMessage="Maximum 50 caractères s'il vous plait."
     * )
     * @ORM\Column(type="string", length=50)
     */
    private $author;

    /**
     * @ORM\Column(type="boolean", options={"default" : 1})
     */
    private $isPublished = true;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $likes = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="wishes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
