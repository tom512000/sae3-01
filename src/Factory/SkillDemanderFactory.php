<?php

namespace App\Factory;

use App\Entity\SkillDemander;
use App\Repository\OffreRepository;
use App\Repository\SkillDemanderRepository;
use App\Repository\SkillRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<SkillDemander>
 *
 * @method        SkillDemander|Proxy                     create(array|callable $attributes = [])
 * @method static SkillDemander|Proxy                     createOne(array $attributes = [])
 * @method static SkillDemander|Proxy                     find(object|array|mixed $criteria)
 * @method static SkillDemander|Proxy                     findOrCreate(array $attributes)
 * @method static SkillDemander|Proxy                     first(string $sortedField = 'id')
 * @method static SkillDemander|Proxy                     last(string $sortedField = 'id')
 * @method static SkillDemander|Proxy                     random(array $attributes = [])
 * @method static SkillDemander|Proxy                     randomOrCreate(array $attributes = [])
 * @method static SkillDemanderRepository|RepositoryProxy repository()
 * @method static SkillDemander[]|Proxy[]                 all()
 * @method static SkillDemander[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static SkillDemander[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static SkillDemander[]|Proxy[]                 findBy(array $attributes)
 * @method static SkillDemander[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static SkillDemander[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class SkillDemanderFactory extends ModelFactory
{
    private OffreRepository $offreRepository;
    private SkillRepository $skillRepository;

    /**
     * Constructeur de la factory.
     */
    public function __construct(OffreRepository $offreRepository, skillRepository $skillRepository)
    {
        parent::__construct();
        $this->offreRepository = $offreRepository;
        $this->skillRepository = $skillRepository;
    }

    /**
     * Définit les valeurs par défaut lors de la création d'un SkillDemander.
     *
     * @return array tableau des valeurs par défaut
     */
    protected function getDefaults(): array
    {
        $existingOffresIds = $this->offreRepository->findOffresIds();
        $existingSkillsIds = $this->skillRepository->findSkillsIds();

        $uniqueCombination = $this->getUniqueCombination($existingOffresIds, $existingSkillsIds);

        return [
            'offre' => $uniqueCombination['offre'],
            'skill' => $uniqueCombination['skill'],
        ];
    }

    /**
     * Méthode d'initialisation de la factory.
     *
     * @return SkillDemanderFactory instance de la factory
     */
    protected function initialize(): self
    {
        return $this;
    }

    /**
     * Retourne la classe de l'entité gérée par la factory.
     *
     * @return string nom de la classe SkillDemander
     */
    protected static function getClass(): string
    {
        return SkillDemander::class;
    }

    /**
     * Génère une combinaison unique d'offre et de skill.
     *
     * @param array $offres tableau des IDs des offres existantes
     * @param array $skills tableau des IDs des skills existants
     *
     * @return array tableau contenant une combinaison unique d'offre et de skill
     */
    private function getUniqueCombination(array $offres, array $skills): array
    {
        $offre = self::faker()->randomElement($offres);
        $skill = self::faker()->randomElement($skills);

        while (SkillDemanderFactory::repository()->findOneBy(['offre' => $offre, 'skill' => $skill])) {
            $offre = self::faker()->randomElement($offres);
            $skill = self::faker()->randomElement($skills);
        }

        return ['offre' => $offre, 'skill' => $skill];
    }
}
