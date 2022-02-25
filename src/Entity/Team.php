<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Team
{
    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        $this->slug = strtolower((new AsciiSlugger())->slug($this->teamName.'-'.$this->season));
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        $this->slug = strtolower((new AsciiSlugger())->slug($this->teamName));
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
     * @Assert\Length(min=3, max=255)
     */
    private $teamName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=3, max=255)
     */
    private $season;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Image(
     *     minWidth = 100,
     *     maxWidth = 2000,
     *     minHeight = 100,
     *     maxHeight = 2000)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Player::class, mappedBy="team")
     */
    private $players;

    /**
     * @ORM\ManyToMany(targetEntity=Training::class, mappedBy="team")
     */
    private $trainings;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="team")
     */
    private $games;

    /**
     * @ORM\OneToMany(targetEntity=MultiPicture::class, mappedBy="team")
     */
    private $multiPictures;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="team")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=News::class, mappedBy="team")
     */
    private $news;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->trainings = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->multiPictures = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->news = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamName(): ?string
    {
        return $this->teamName;
    }

    public function setTeamName(string $teamName): self
    {
        $this->teamName = $teamName;

        return $this;
    }

    public function getSeason(): ?string
    {
        return $this->season;
    }

    public function setSeason(string $season): self
    {
        $this->season = $season;

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

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getTeam() === $this) {
                $player->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Training[]
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings[] = $training;
            $training->addTeam($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->removeElement($training)) {
            $training->removeTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setTeam($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getTeam() === $this) {
                $game->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MultiPicture[]
     */
    public function getMultiPictures(): Collection
    {
        return $this->multiPictures;
    }

    public function addMultiPicture(MultiPicture $multiPicture): self
    {
        if (!$this->multiPictures->contains($multiPicture)) {
            $this->multiPictures[] = $multiPicture;
            $multiPicture->setTeam($this);
        }

        return $this;
    }

    public function removeMultiPicture(MultiPicture $multiPicture): self
    {
        if ($this->multiPictures->removeElement($multiPicture)) {
            // set the owning side to null (unless already changed)
            if ($multiPicture->getTeam() === $this) {
                $multiPicture->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setTeam($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getTeam() === $this) {
                $user->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|News[]
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): self
    {
        if (!$this->news->contains($news)) {
            $this->news[] = $news;
            $news->setTeam($this);
        }

        return $this;
    }

    public function removeNews(News $news): self
    {
        if ($this->news->removeElement($news)) {
            // set the owning side to null (unless already changed)
            if ($news->getTeam() === $this) {
                $news->setTeam(null);
            }
        }

        return $this;
    }
    
    public function __toString()
    {
        return $this->getTeamName();
    }
}
