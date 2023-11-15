<?php

namespace App\Entity;

use App\Repository\UserRepository;
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
    #[ORM\Column(length: 10)]
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
}
