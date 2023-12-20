<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'skill', targetEntity: SkillDemander::class)]
    private Collection $skillDemanders;

    /**
     * Constructeur de la classe Skill.
     */
    public function __construct()
    {
        $this->skillDemanders = new ArrayCollection();
    }

    /**
     * Obtient l'identifiant de la compétence.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtient le libellé de la compétence.
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * Définit le libellé de la compétence.
     *
     * @param string $libelle le libellé de la compétence à définir
     *
     * @return skill L'instance actuelle de la compétence
     */
    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Obtient la collection de demandes de compétences associée à la compétence.
     *
     * @return Collection<int, SkillDemander>
     */
    public function getSkillDemanders(): Collection
    {
        return $this->skillDemanders;
    }

    /**
     * Ajoute une demande de compétence à la collection associée à la compétence.
     *
     * @param SkillDemander $skillDemander la demande de compétence à ajouter
     *
     * @return skill L'instance actuelle de la compétence
     */
    public function addSkillDemander(SkillDemander $skillDemander): static
    {
        if (!$this->skillDemanders->contains($skillDemander)) {
            $this->skillDemanders->add($skillDemander);
            $skillDemander->setSkill($this);
        }

        return $this;
    }

    /**
     * Supprime une demande de compétence de la collection associée à la compétence.
     *
     * @param SkillDemander $skillDemander la demande de compétence à supprimer
     *
     * @return skill L'instance actuelle de la compétence
     */
    public function removeSkillDemander(SkillDemander $skillDemander): static
    {
        if ($this->skillDemanders->removeElement($skillDemander)) {
            if ($skillDemander->getSkill() === $this) {
                $skillDemander->setSkill(null);
            }
        }

        return $this;
    }
}
