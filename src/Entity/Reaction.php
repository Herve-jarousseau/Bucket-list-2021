<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 */
class Reaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Le champ Pseudo est obligatoire.")
     * @Assert\Length(
     *     min=2,
     *     max=50,
     *     minMessage="Minimum 2 caractères s'il vous plait.",
     *     maxMessage="Maximum 50 caractères s'il vous plait."
     * )
     * @ORM\Column(type="string", length=50)
     */
    private $username;

    /**
     * @Assert\NotBlank(message="Le champ message est obligatoire.")
     * @Assert\Length(
     *     min=2,
     *     max=2000,
     *     minMessage="Minimum 2 caractères s'il vous plait.",
     *     maxMessage="Maximum 2 000 caractères s'il vous plait."
     * )
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity=Wish::class, inversedBy="reactions")
     */
    private $wish;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

    public function getWish(): ?Wish
    {
        return $this->wish;
    }

    public function setWish(?Wish $wish): self
    {
        $this->wish = $wish;

        return $this;
    }
}
