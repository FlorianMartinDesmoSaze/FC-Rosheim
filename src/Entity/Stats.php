<?php

namespace App\Entity;

use App\Repository\StatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatsRepository::class)
 */
class Stats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $gamePlayed;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cleanSheets;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $saves;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $assists;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $goals;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $yellowCards;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $redCards;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGamePlayed(): ?int
    {
        return $this->gamePlayed;
    }

    public function setGamePlayed(?int $gamePlayed): self
    {
        $this->gamePlayed = $gamePlayed;

        return $this;
    }

    public function getCleanSheets(): ?int
    {
        return $this->cleanSheets;
    }

    public function setCleanSheets(?int $cleanSheets): self
    {
        $this->cleanSheets = $cleanSheets;

        return $this;
    }

    public function getSaves(): ?int
    {
        return $this->saves;
    }

    public function setSaves(?int $saves): self
    {
        $this->saves = $saves;

        return $this;
    }

    public function getAssists(): ?int
    {
        return $this->assists;
    }

    public function setAssists(?int $assists): self
    {
        $this->assists = $assists;

        return $this;
    }

    public function getGoals(): ?int
    {
        return $this->goals;
    }

    public function setGoals(?int $goals): self
    {
        $this->goals = $goals;

        return $this;
    }

    public function getYellowCards(): ?int
    {
        return $this->yellowCards;
    }

    public function setYellowCards(?int $yellowCards): self
    {
        $this->yellowCards = $yellowCards;

        return $this;
    }

    public function getRedCards(): ?int
    {
        return $this->redCards;
    }

    public function setRedCards(?int $redCards): self
    {
        $this->redCards = $redCards;

        return $this;
    }
}
