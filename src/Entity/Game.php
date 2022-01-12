<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
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
    private $opponent;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scoreTeam;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scoreOpponent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $gameDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $home;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOpponent(): ?string
    {
        return $this->opponent;
    }

    public function setOpponent(string $opponent): self
    {
        $this->opponent = $opponent;

        return $this;
    }

    public function getScoreTeam(): ?int
    {
        return $this->scoreTeam;
    }

    public function setScoreTeam(?int $scoreTeam): self
    {
        $this->scoreTeam = $scoreTeam;

        return $this;
    }

    public function getScoreOpponent(): ?int
    {
        return $this->scoreOpponent;
    }

    public function setScoreOpponent(?int $scoreOpponent): self
    {
        $this->scoreOpponent = $scoreOpponent;

        return $this;
    }

    public function getGameDate(): ?\DateTimeInterface
    {
        return $this->gameDate;
    }

    public function setGameDate(\DateTimeInterface $gameDate): self
    {
        $this->gameDate = $gameDate;

        return $this;
    }

    public function getHome(): ?bool
    {
        return $this->home;
    }

    public function setHome(bool $home): self
    {
        $this->home = $home;

        return $this;
    }
}
