<?php

namespace App\Factory;

use App\Entity\Inscrire;
use App\Repository\InscrireRepository;
use App\Repository\OffreRepository;
use App\Repository\UserRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Inscrire>
 *
 * @method        Inscrire|Proxy create(array|callable $attributes = [])
 * @method static Inscrire|Proxy createOne(array $attributes = [])
 * @method static Inscrire|Proxy find(object|array|mixed $criteria)
 * @method static Inscrire|Proxy findOrCreate(array $attributes)
 * @method static Inscrire|Proxy first(string $sortedField = 'id')
 * @method static Inscrire|Proxy last(string $sortedField = 'id')
 * @method static Inscrire|Proxy random(array $attributes = [])
 * @method static Inscrire|Proxy randomOrCreate(array $attributes = [])
 * @method static InscrireRepository|RepositoryProxy repository()
 * @method static Inscrire[]|Proxy[] all()
 * @method static Inscrire[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Inscrire[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Inscrire[]|Proxy[] findBy(array $attributes)
 * @method static Inscrire[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Inscrire[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class InscrireFactory extends ModelFactory
{
    private OffreRepository  $offreRepository;
    private userRepository  $userRepository;

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */

    public function __construct(OffreRepository $offreRepository, userRepository $userRepository)
    {
        parent::__construct();
        $this->offreRepository = $offreRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        $existingOffresIds = $this->offreRepository->findOffresIds();
        $existingUsersIds = $this->userRepository->findUsersIds();


        return [
            'Status' => self::faker()->randomNumber(),
            'dateDemande' => self::faker()->dateTime(),
            'Offre' => self::faker()->randomElement($existingOffresIds),
            'User' => self::faker()->randomElement($existingUsersIds),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Inscrire $inscrire): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Inscrire::class;
    }
}
