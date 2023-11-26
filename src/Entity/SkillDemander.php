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

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }
}
