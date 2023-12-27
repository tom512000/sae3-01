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

    #[ORM\ManyToOne(targetEntity: Entreprise::class)]
    #[ORM\JoinColumn(name: 'idEntreprise', referencedColumnName: 'id')]
    private ?Entreprise $entreprise = null;

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

    #[ORM\OneToMany(mappedBy: 'Offre', targetEntity: Inscrire::class)]
    private Collection $inscrires;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $Type = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $level = null;

    #[ORM\OneToMany(mappedBy: 'offre', targetEntity: SkillDemander::class)]
    private Collection $skillDemanders;

    /**
     * Constructeur de la classe Offre.
     */
    public function __construct()
    {
        $this->inscrires = new ArrayCollection();
        $this->skillDemanders = new ArrayCollection();
    }

    /**
     * Obtient l'identifiant de l'offre.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtient l'entreprise associée à l'offre.
     */
    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    /**
     * Définit l'entreprise associée à l'offre.
     *
     * @param entreprise|null $entreprise L'entreprise à définir
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Obtient le nom de l'offre.
     */
    public function getNomOffre(): ?string
    {
        return $this->nomOffre;
    }

    /**
     * Définit le nom de l'offre.
     *
     * @param string $nomOffre le nom de l'offre à définir
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function setNomOffre(string $nomOffre): static
    {
        $this->nomOffre = $nomOffre;

        return $this;
    }

    /**
     * Obtient la durée de l'offre.
     */
    public function getDuree(): ?int
    {
        return $this->duree;
    }

    /**
     * Définit la durée de l'offre.
     *
     * @param int $duree la durée de l'offre à définir
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Obtient le lieu de l'offre.
     */
    public function getLieux(): ?string
    {
        return $this->lieux;
    }

    /**
     * Définit le lieu de l'offre.
     *
     * @param string $lieux le lieu de l'offre à définir
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function setLieux(string $lieux): static
    {
        $this->lieux = $lieux;

        return $this;
    }

    /**
     * Obtient la date de début de l'offre.
     */
    public function getJourDeb(): ?\DateTimeInterface
    {
        return $this->jourDeb;
    }

    /**
     * Obtient la date de début de l'offre au format de chaîne de caractères.
     */
    public function getJourDebString(): string
    {
        return $this->jourDeb->format('d F Y');
    }

    /**
     * Définit la date de début de l'offre.
     *
     * @param \DateTimeInterface $jourDeb la date de début à définir
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function setJourDeb(\DateTimeInterface $jourDeb): static
    {
        $this->jourDeb = $jourDeb;

        return $this;
    }

    /**
     * Obtient le nombre de places de l'offre.
     */
    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    /**
     * Définit le nombre de places de l'offre.
     *
     * @param int $nbPlace le nombre de places à définir
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function setNbPlace(int $nbPlace): static
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    /**
     * Obtient la description de l'offre.
     */
    public function getDescrip(): ?string
    {
        return $this->descrip;
    }

    /**
     * Définit la description de l'offre.
     *
     * @param string|null $descrip la description à définir
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function setDescrip(?string $descrip): static
    {
        $this->descrip = $descrip;

        return $this;
    }

    /**
     * Obtient la collection d'inscriptions associée à l'offre.
     *
     * @return Collection<int, Inscrire>
     */
    public function getInscrires(): Collection
    {
        return $this->inscrires;
    }

    /**
     * Ajoute une inscription à la collection d'inscriptions associée à l'offre.
     *
     * @param inscrire $inscrire L'inscription à ajouter
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function addInscrire(Inscrire $inscrire): static
    {
        if (!$this->inscrires->contains($inscrire)) {
            $this->inscrires->add($inscrire);
            $inscrire->setOffre($this);
        }

        return $this;
    }

    /**
     * Supprime une inscription de la collection d'inscriptions associée à l'offre.
     *
     * @param inscrire $inscrire L'inscription à supprimer
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function removeInscrire(Inscrire $inscrire): static
    {
        if ($this->inscrires->removeElement($inscrire)) {
            if ($inscrire->getOffre() === $this) {
                $inscrire->setOffre(null);
            }
        }

        return $this;
    }

    /**
     * Obtient le type associé à l'offre.
     */
    public function getType(): ?Type
    {
        return $this->Type;
    }

    /**
     * Définit le type associé à l'offre.
     *
     * @param Type|null $Type le type à définir
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function setType(?Type $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    /**
     * Obtient le niveau de l'offre.
     */
    public function getLevel(): ?string
    {
        return $this->level;
    }

    /**
     * Définit le niveau de l'offre.
     *
     * @param string|null $level le niveau à définir
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function setLevel(?string $level): static
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Obtient la collection de demandes de compétences associée à l'offre.
     *
     * @return Collection<int, SkillDemander>
     */
    public function getSkillDemanders(): Collection
    {
        return $this->skillDemanders;
    }

    /**
     * Ajoute une demande de compétence à la collection associée à l'offre.
     *
     * @param SkillDemander $skillDemander la demande de compétence à ajouter
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function addSkillDemander(SkillDemander $skillDemander): static
    {
        if (!$this->skillDemanders->contains($skillDemander)) {
            $this->skillDemanders->add($skillDemander);
            $skillDemander->setOffre($this);
        }

        return $this;
    }

    /**
     * Supprime une demande de compétence de la collection associée à l'offre.
     *
     * @param SkillDemander $skillDemander la demande de compétence à supprimer
     *
     * @return offre L'instance actuelle de l'offre
     */
    public function removeSkillDemander(SkillDemander $skillDemander): static
    {
        if ($this->skillDemanders->removeElement($skillDemander)) {
            if ($skillDemander->getOffre() === $this) {
                $skillDemander->setOffre(null);
            }
        }

        return $this;
    }
}
