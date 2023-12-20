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
    #[ORM\JoinColumn(name: 'idOffre', referencedColumnName: 'id')]
    private ?Offre $Offre = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'inscrires')]
    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'id')]
    private ?User $User = null;

    #[ORM\Column]
    private ?int $Status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDemande = null;

    /**
     * Obtient l'offre à laquelle l'utilisateur est inscrit.
     */
    public function getOffre(): ?Offre
    {
        return $this->Offre;
    }

    /**
     * Définit l'offre à laquelle l'utilisateur est inscrit.
     *
     * @param offre|null $Offre L'offre à définir
     *
     * @return inscrire L'instance actuelle de l'inscription
     */
    public function setOffre(?Offre $Offre): static
    {
        $this->Offre = $Offre;

        return $this;
    }

    /**
     * Obtient l'utilisateur inscrit.
     */
    public function getUser(): ?User
    {
        return $this->User;
    }

    /**
     * Définit l'utilisateur inscrit.
     *
     * @param user|null $User L'utilisateur à définir
     *
     * @return inscrire L'instance actuelle de l'inscription
     */
    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    /**
     * Obtient le statut de l'inscription.
     */
    public function getStatus(): ?int
    {
        return $this->Status;
    }

    /**
     * Définit le statut de l'inscription.
     *
     * @param int $Status le statut à définir
     *
     * @return inscrire L'instance actuelle de l'inscription
     */
    public function setStatus(int $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    /**
     * Obtient la date de la demande d'inscription.
     */
    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    /**
     * Définit la date de la demande d'inscription.
     *
     * @param \DateTimeInterface $dateDemande la date à définir
     *
     * @return inscrire L'instance actuelle de l'inscription
     */
    public function setDateDemande(\DateTimeInterface $dateDemande): static
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }
}
