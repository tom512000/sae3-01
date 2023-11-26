<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;
use Faker\Provider\Image;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $nomEnt = null;

    #[ORM\Column(length: 128)]
    private ?string $adresse = null;
    #[ORM\Column(length: 128)]
    private ?string $mail = null;

    #[ORM\Column(length: 128)]
    private ?string $siteWeb = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo=$logo;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEnt(): ?string
    {
        return $this->nomEnt;
    }

    public function setNomEnt(string $nomEnt): static
    {
        $this->nomEnt = $nomEnt;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(string $siteWeb): static
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }
}
