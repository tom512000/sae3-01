<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ID_entreprise = null;

    #[ORM\Column(length: 128)]
    private ?string $nomEnt = null;

    #[ORM\Column(length: 128)]
    private ?string $adresse = null;
    #[ORM\Column(length: 128)]
    private ?string $mail = null;

    #[ORM\Column(length: 128)]
    private ?string $siteWeb = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDEntreprise(): ?int
    {
        return $this->ID_entreprise;
    }

    public function setIDEntreprise(int $ID_entreprise): static
    {
        $this->ID_entreprise = $ID_entreprise;

        return $this;
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
