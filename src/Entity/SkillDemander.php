<?php

namespace App\Entity;

use App\Repository\SkillDemanderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillDemanderRepository::class)]
class SkillDemander
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'skillDemanders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Skill $skill = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'skillDemanders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $offre = null;

    /**
     * Obtient la compétence associée à la demande de compétence.
     */
    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    /**
     * Définit la compétence associée à la demande de compétence.
     *
     * @param Skill|null $skill la compétence à définir
     *
     * @return skillDemander L'instance actuelle de la demande de compétence
     */
    public function setSkill(?Skill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Obtient l'offre associée à la demande de compétence.
     */
    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    /**
     * Définit l'offre associée à la demande de compétence.
     *
     * @param offre|null $offre L'offre à définir
     *
     * @return skillDemander L'instance actuelle de la demande de compétence
     */
    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }
}
