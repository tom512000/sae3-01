<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ID_offre = null;

    #[ORM\Column]
    private ?int $ID_type = null;

    #[ORM\Column(nullable: true)]
    private ?int $ID_entreprise = null;

    #[ORM\Column(length: 128)]
    private ?string $nomOffre = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column(length: 128)]
    private ?string $lieux = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $jourDeb = null;

    #[ORM\Column]
    private ?int $nbPlace = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descrip = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDOffre(): ?int
    {
        return $this->ID_offre;
    }

    public function setIDOffre(int $ID_offre): static
    {
        $this->ID_offre = $ID_offre;

        return $this;
    }

    public function getIDType(): ?int
    {
        return $this->ID_type;
    }

    public function setIDType(int $ID_type): static
    {
        $this->ID_type = $ID_type;

        return $this;
    }

    public function getIDEntreprise(): ?int
    {
        return $this->ID_entreprise;
    }

    public function setIDEntreprise(?int $ID_entreprise): static
    {
        $this->ID_entreprise = $ID_entreprise;

        return $this;
    }

    public function getNomOffre(): ?string
    {
        return $this->nomOffre;
    }

    public function setNomOffre(string $nomOffre): static
    {
        $this->nomOffre = $nomOffre;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getLieux(): ?string
    {
        return $this->lieux;
    }

    public function setLieux(string $lieux): static
    {
        $this->lieux = $lieux;

        return $this;
    }

    public function getJourDeb(): string
    {
        return $this->jourDeb->format('d F Y');
    }

    public function setJourDeb(\DateTimeInterface $jourDeb): static
    {
        $this->jourDeb = $jourDeb;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(int $nbPlace): static
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    public function getDescrip(): ?string
    {
        return $this->descrip;
    }

    public function setDescrip(?string $descrip): static
    {
        $this->descrip = $descrip;

        return $this;
    }
}
