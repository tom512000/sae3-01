<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(targetEntity:Entreprise::class)]
    #[ORM\JoinColumn(name:"idEntreprise", referencedColumnName:"id")]
    private ?Entreprise $entreprise = null;

    #[ORM\Column(length: 128)]
    private ?string $nomOffre = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column(length: 128)]
    private ?string $lieux = null;


    #[ORM\Column(type:Types::DATE_MUTABLE)]

    private ?\DateTimeInterface $jourDeb = null;

    #[ORM\Column]
    private ?int $nbPlace = null;


    #[ORM\Column(length:255, nullable:true)]

    private ?string $descrip = null;

    #[ORM\OneToMany(mappedBy: 'Offre', targetEntity: Inscrire::class)]
    private Collection $inscrires;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $Type = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $level = null;

    #[ORM\OneToMany(mappedBy: 'offre', targetEntity: SkillDemander::class)]
    private Collection $skillDemanders;

    public function __construct()
    {
        $this->inscrires = new ArrayCollection();
        $this->skillDemanders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

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

    public function getJourDeb(): ?\DateTimeInterface
    {
        return $this->jourDeb;
    }

    public function getJourDebString(): string
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

    /**
     * @return Collection<int, Inscrire>
     */
    public function getInscrires(): Collection
    {
        return $this->inscrires;
    }

    public function addInscrire(Inscrire $inscrire): static
    {
        if (!$this->inscrires->contains($inscrire)) {
            $this->inscrires->add($inscrire);
            $inscrire->setOffre($this);
        }

        return $this;
    }

    public function removeInscrire(Inscrire $inscrire): static
    {
        if ($this->inscrires->removeElement($inscrire)) {
            // set the owning side to null (unless already changed)
            if ($inscrire->getOffre() === $this) {
                $inscrire->setOffre(null);
            }
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->Type;
    }

    public function setType(?Type $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): static
    {
        $this->level = $level;

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
            $skillDemander->setOffre($this);
        }

        return $this;
    }

    public function removeSkillDemander(SkillDemander $skillDemander): static
    {
        if ($this->skillDemanders->removeElement($skillDemander)) {
            // set the owning side to null (unless already changed)
            if ($skillDemander->getOffre() === $this) {
                $skillDemander->setOffre(null);
            }
        }

        return $this;
    }
}
