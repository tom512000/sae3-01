<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'Type', targetEntity: Offre::class)]
    private Collection $offres;

    /**
     * Constructeur de la classe Type.
     */
    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }

    /**
     * Obtient l'ID du Type.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtient le libellé du Type.
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * Définit le libellé du Type.
     *
     * @return $this
     */
    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Obtient la collection des Offres liées à ce Type.
     *
     * @return Collection<int, Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    /**
     * Ajoute une relation Offre à ce Type.
     *
     * @return $this
     */
    public function addOffre(Offre $offre): static
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->setType($this);
        }

        return $this;
    }

    /**
     * Supprime une relation Offre de ce Type.
     *
     * @return $this
     */
    public function removeOffre(Offre $offre): static
    {
        if ($this->offres->removeElement($offre)) {
            if ($offre->getType() === $this) {
                $offre->setType(null);
            }
        }

        return $this;
    }
}
