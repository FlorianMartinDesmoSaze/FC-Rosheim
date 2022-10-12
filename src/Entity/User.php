<?php

namespace App\Entity;

use App\Repository\UserRepository;
<<<<<<< HEAD
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
=======
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
>>>>>>> prod_flo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
<<<<<<< HEAD
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
=======
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas une adresse valide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
>>>>>>> prod_flo
     */
    private $password;

    /**
<<<<<<< HEAD
     * @ORM\Column(type="json", nullable=true)
     */
    private $role = [];

    /**
=======
>>>>>>> prod_flo
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
<<<<<<< HEAD
     * @ORM\Column(type="string", length=12, nullable=true)
=======
     * @ORM\Column(type="string", length=40, nullable=true)
>>>>>>> prod_flo
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
<<<<<<< HEAD
    private $last_name;
=======
    private $lastName;
>>>>>>> prod_flo

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $first_name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthdate;

    /**
<<<<<<< HEAD
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $license;

=======
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    private $license;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="users")
     */
    private $team;

    /**
     * @ORM\OneToMany(targetEntity=News::class, mappedBy="user")
     */
    private $news;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="user")
     */
    private $events;

    /**
     * @ORM\OneToOne(targetEntity=Staff::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $staff;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->license = false;
    }

>>>>>>> prod_flo
    public function getId(): ?int
    {
        return $this->id;
    }

<<<<<<< HEAD
    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;
=======
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
>>>>>>> prod_flo

        return $this;
    }

<<<<<<< HEAD
    public function getPassword(): ?string
=======
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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
>>>>>>> prod_flo
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

<<<<<<< HEAD
    public function getRole(): ?array
    {
        return $this->role;
    }

    public function setRole(?array $role): self
    {
        $this->role = $role;

        return $this;
=======
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
>>>>>>> prod_flo
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getLastName(): ?string
    {
<<<<<<< HEAD
        return $this->last_name;
    }

    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;
=======
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
>>>>>>> prod_flo

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getLicense(): ?bool
    {
        return $this->license;
    }

    public function setLicense(bool $license): self
    {
        $this->license = $license;

        return $this;
    }
<<<<<<< HEAD
=======

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

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
            $news->setUser($this);
        }

        return $this;
    }

    public function removeNews(News $news): self
    {
        if ($this->news->removeElement($news)) {
            // set the owning side to null (unless already changed)
            if ($news->getUser() === $this) {
                $news->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        // unset the owning side of the relation if necessary
        if ($staff === null && $this->staff !== null) {
            $this->staff->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($staff !== null && $staff->getUser() !== $this) {
            $staff->setUser($this);
        }

        $this->staff = $staff;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function __toString()
    {
        if ($this->getFirstName() !== null && $this->getLastName() !== null) {
            return $this->getFirstName() . " " . $this->getLastName();
        } else {
            return $this->getEmail();
        }
    }
>>>>>>> prod_flo
}
