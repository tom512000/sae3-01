<?php

namespace App\Entity;

use App\Repository\InscrireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscrireRepository::class)]
class Inscrire
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'inscrires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $Offre = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'inscrires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\Column]
    private ?int $Status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDemande = null;

    public function getOffre(): ?Offre
    {
        return $this->Offre;
    }

    public function setOffre(?Offre $Offre): static
    {
        $this->Offre = $Offre;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->Status;
    }

    public function setStatus(int $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeInterface $dateDemande): static
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }
}
