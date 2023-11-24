<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 180)]
    private string $firstName;
    #[ORM\Column(length: 180)]
    private string $lastName;
    #[ORM\Column(length: 20)]
    private string $phone;
    #[ORM\Column]
    private int $status;
    #[ORM\Column(length: 10)]
    private string $dateNais;
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var ?string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Inscrire::class)]
    private Collection $inscrires;

    public function __construct()
    {
        $this->inscrires = new ArrayCollection();
    }
    #[ORM\Column(type: 'string')]
    private string $cv;

    public function getCv(): string
    {
        return $this->cv;
    }

    public function setCv(string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    #[ORM\Column(type: 'string')]
    private string $lettreMotiv;

    public function getLettreMotiv(): string
    {
        return $this->lettreMotiv;
    }

    public function setLettreMotiv(string $lettreMotiv): self
    {
        $this->lettreMotiv = $lettreMotiv;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return ?string
     */
    public  function getFirstName(): ?string{
        return $this->firstName;
    }

    /**
     * @param ?string $firstName
     */
    public  function setFirstName(?string $firstName):void {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public  function getLastName(): string{
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public  function setLastName(string $lastName):void {
        $this->lastName = $lastName;
    }

    /**
     * @return ?string
     */
    public  function getPhone(): ?string{
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public  function setPhone(string $phone):void {
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public  function getStatus(): int{
        return $this->status;
    }

    /**
     * @param int $status
     */
    public  function setStatus(int $status):void {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public  function getDateNais(): string{
        return $this->dateNais;
    }

    /**
     * @param string $dateNais
     */
    public  function setDateNais(string $dateNais):void {
        $this->dateNais = $dateNais;
    }

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
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Inscrire>
     */
    public function getInscrires(): Collection
    {
        return $this->inscrires;
    }

    public function addInscrire(Inscrire $inscrire): static
    {
        if (!$this->inscrires->contains($inscrire)) {
            $this->inscrires->add($inscrire);
            $inscrire->setUser($this);
        }

        return $this;
    }

    public function removeInscrire(Inscrire $inscrire): static
    {
        if ($this->inscrires->removeElement($inscrire)) {
            // set the owning side to null (unless already changed)
            if ($inscrire->getUser() === $this) {
                $inscrire->setUser(null);
            }
        }

        return $this;
    }
}
