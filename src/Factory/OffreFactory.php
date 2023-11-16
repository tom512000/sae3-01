<?php

namespace App\Factory;

use App\Entity\Offre;
use App\Repository\OffreRepository;
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
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    private \Transliterator $transliterator;

    public function __construct()
    {
        parent::__construct();
        $this->transliterator = \Transliterator::create('Any-Lower; Latin-ASCII; Lower()');
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'ID_offre' => self::faker()->randomNumber(),
            'ID_type' => self::faker()->randomNumber(),
            'duree' => self::faker()->randomNumber(),
            'jourDeb' => self::faker()->dateTime(),
            'lieux' => self::faker()->address(),
            'nbPlace' => self::faker()->randomNumber(),
            'nomOffre' => self::faker()->name(),
        ];
    }

    protected function normalizeName($name): string
    {
        $name = str_replace('/[^a-z]+/', '-', $name);
        return $this->transliterator->transliterate($name);
    }




    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Offre $offre): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Offre::class;
    }
}
