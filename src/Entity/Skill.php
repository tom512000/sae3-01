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

    public function __construct()
    {
        $this->skillDemanders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, SkillDemander>
     */
    public function getSkillDemanders(): Collection
    {
        return $this->skillDemanders;
    }

    public function addSkillDemander(SkillDemander $skillDemander): static
    {
        if (!$this->skillDemanders->contains($skillDemander)) {
            $this->skillDemanders->add($skillDemander);
            $skillDemander->setSkill($this);
        }

        return $this;
    }

    public function removeSkillDemander(SkillDemander $skillDemander): static
    {
        if ($this->skillDemanders->removeElement($skillDemander)) {
            // set the owning side to null (unless already changed)
            if ($skillDemander->getSkill() === $this) {
                $skillDemander->setSkill(null);
            }
        }

        return $this;
    }
}
