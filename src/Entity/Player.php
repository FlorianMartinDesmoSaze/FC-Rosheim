<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlayerRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Player
{

    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        $this->slug = strtolower((new AsciiSlugger())->slug($this->firstName.'-'.$this->lastName));
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        $this->slug = strtolower((new AsciiSlugger())->slug($this->firstName.'-'.$this->lastName));
    }
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=2, max=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=2, max=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $number;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Image(
     *     minWidth = 100,
     *     maxWidth = 400,
     *     minHeight = 100,
     *     maxHeight = 400)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="players")
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity=Position::class, inversedBy="players")
     */
    private $position;

    /**
     * @ORM\OneToOne(targetEntity=Stats::class, mappedBy="player", cascade={"persist", "remove"})
     */
    private $stats;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getStats(): ?Stats
    {
        return $this->stats;
    }

    public function setStats(?Stats $stats): self
    {
        // unset the owning side of the team if necessary
        if ($stats === null && $this->stats !== null) {
            $this->stats->setPlayer(null);
        }

        // set the owning side of the team if necessary
        if ($stats !== null && $stats->getPlayer() !== $this) {
            $stats->setPlayer($this);
        }

        $this->stats = $stats;

        return $this;
    }
}
