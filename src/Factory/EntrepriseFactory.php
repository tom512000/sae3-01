<?php

namespace App\Factory;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Entreprise>
 *
 * @method        Entreprise|Proxy create(array|callable $attributes = [])
 * @method static Entreprise|Proxy createOne(array $attributes = [])
 * @method static Entreprise|Proxy find(object|array|mixed $criteria)
 * @method static Entreprise|Proxy findOrCreate(array $attributes)
 * @method static Entreprise|Proxy first(string $sortedField = 'id')
 * @method static Entreprise|Proxy last(string $sortedField = 'id')
 * @method static Entreprise|Proxy random(array $attributes = [])
 * @method static Entreprise|Proxy randomOrCreate(array $attributes = [])
 * @method static EntrepriseRepository|RepositoryProxy repository()
 * @method static Entreprise[]|Proxy[] all()
 * @method static Entreprise[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Entreprise[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Entreprise[]|Proxy[] findBy(array $attributes)
 * @method static Entreprise[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Entreprise[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class EntrepriseFactory extends ModelFactory
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
        $nomEnt = self::faker()->company();
        $email = $this->generateEmail($nomEnt);
        $siteWeb = $this->generateSiteWeb($nomEnt);

        return [
            'adresse' => self::faker()->address(),
            'nomEnt' => $nomEnt,
            'mail'=>$email,
            'siteWeb' => $siteWeb,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Entreprise $entreprise): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Entreprise::class;
    }


    protected function normalizeName($name): string
    {
        $name = str_replace('/[^a-z]+/', '-', $name);
        return $this->transliterator->transliterate($name);
    }

    protected function generateEmail($Name): string
    {
        $normalizedName = $this->normalizeName(strtr($Name, array(' ' => '.')));

        return $normalizedName.'@'.self::faker()->domainName();
    }

    protected function generateSiteWeb($Name): string
    {
        $normalizedName = $this->normalizeName(strtr($Name, array(' ' => '')));

        return 'https://'.$normalizedName.'.'.self::faker()->domainName();
    }
}
