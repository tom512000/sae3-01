<?php

namespace App\Factory;

use App\Entity\Offre;
use App\Repository\EntrepriseRepository;
use App\Repository\OffreRepository;
use App\Repository\TypeRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Offre>
 *
 * @method        Offre|Proxy                     create(array|callable $attributes = [])
 * @method static Offre|Proxy                     createOne(array $attributes = [])
 * @method static Offre|Proxy                     find(object|array|mixed $criteria)
 * @method static Offre|Proxy                     findOrCreate(array $attributes)
 * @method static Offre|Proxy                     first(string $sortedField = 'id')
 * @method static Offre|Proxy                     last(string $sortedField = 'id')
 * @method static Offre|Proxy                     random(array $attributes = [])
 * @method static Offre|Proxy                     randomOrCreate(array $attributes = [])
 * @method static OffreRepository|RepositoryProxy repository()
 * @method static Offre[]|Proxy[]                 all()
 * @method static Offre[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Offre[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Offre[]|Proxy[]                 findBy(array $attributes)
 * @method static Offre[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Offre[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class OffreFactory extends ModelFactory
{
    private \Transliterator $transliterator;
    private EntrepriseRepository $entrepriseRepository;
    private TypeRepository $typeRepository;

    /**
     * Constructeur de la factory.
     */
    public function __construct(EntrepriseRepository $entrepriseRepository, TypeRepository $typeRepository)
    {
        parent::__construct();
        $this->transliterator = \Transliterator::create('Any-Lower; Latin-ASCII; Lower()');
        $this->entrepriseRepository = $entrepriseRepository;
        $this->typeRepository = $typeRepository;
    }

    /**
     * Définit les valeurs par défaut lors de la création d'une offre.
     *
     * @return array tableau des valeurs par défaut
     */
    protected function getDefaults(): array
    {
        $existingEntrepriseIds = $this->entrepriseRepository->findEntreprises();
        $existingTypesIds = $this->typeRepository->findTypesIds();
        $level = self::faker()->numberBetween(0, 5);

        if (0 == $level) {
            $level = 'BAC';
        } else {
            $level = 'BAC +'.$level;
        }

        return [
            'Type' => self::faker()->randomElement($existingTypesIds),
            'entreprise' => self::faker()->randomElement($existingEntrepriseIds),
            'duree' => self::faker()->numberBetween(5, 300),
            'jourDeb' => self::faker()->dateTime(),
            'lieux' => self::faker()->address(),
            'nbPlace' => self::faker()->numberBetween(2, 40),
            'nomOffre' => self::faker()->jobTitle(),
            'descrip' => self::faker()->realText(),
            'level' => $level,
        ];
    }

    /**
     * Normalise un nom en convertissant les caractères spéciaux.
     *
     * @param string $name nom à normaliser
     *
     * @return string nom normalisé
     */
    protected function normalizeName($name): string
    {
        $name = str_replace('/[^a-z]+/', '-', $name);

        return $this->transliterator->transliterate($name);
    }

    /**
     * Méthode d'initialisation de la factory.
     *
     * @return OffreFactory instance de la factory
     */
    protected function initialize(): self
    {
        return $this;
    }

    /**
     * Retourne la classe de l'entité gérée par la factory.
     *
     * @return string nom de la classe Offre
     */
    protected static function getClass(): string
    {
        return Offre::class;
    }
}
