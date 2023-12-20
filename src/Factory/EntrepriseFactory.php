<?php

namespace App\Factory;

use App\Entity\Entreprise;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Entreprise>
 *
 * @method        Entreprise|Proxy     create(array|callable $attributes = [])
 * @method static Entreprise|Proxy     createOne(array $attributes = [])
 * @method static Entreprise|Proxy     find(object|array|mixed $criteria)
 * @method static Entreprise|Proxy     findOrCreate(array $attributes)
 * @method static Entreprise|Proxy     first(string $sortedField = 'id')
 * @method static Entreprise|Proxy     last(string $sortedField = 'id')
 * @method static Entreprise|Proxy     random(array $attributes = [])
 * @method static Entreprise|Proxy     randomOrCreate(array $attributes = [])
 * @method static Entreprise[]|Proxy[] all()
 * @method static Entreprise[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Entreprise[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Entreprise[]|Proxy[] findBy(array $attributes)
 * @method static Entreprise[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Entreprise[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class EntrepriseFactory extends ModelFactory
{
    private \Transliterator $transliterator;

    /**
     * Constructeur de la factory.
     */
    public function __construct()
    {
        parent::__construct();
        $this->transliterator = \Transliterator::create('Any-Lower; Latin-ASCII; Lower()');
    }

    /**
     * Définit les valeurs par défaut lors de la création d'une entreprise.
     *
     * @return array tableau des valeurs par défaut
     */
    protected function getDefaults(): array
    {
        $nomEnt = self::faker()->company();
        $email = $this->generateEmail($nomEnt);
        $siteWeb = $this->generateSiteWeb($nomEnt);
        $logo = $this->generateLogo($nomEnt);

        return [
            'adresse' => self::faker()->address(),
            'nomEnt' => $nomEnt,
            'mail' => $email,
            'siteWeb' => $siteWeb,
            'logo' => $logo,
        ];
    }

    /**
     * Méthode d'initialisation de la factory.
     *
     * @return EntrepriseFactory instance de la factory
     */
    protected function initialize(): self
    {
        return $this;
    }

    /**
     * Retourne la classe de l'entité gérée par la factory.
     *
     * @return string nom de la classe Entreprise
     */
    protected static function getClass(): string
    {
        return Entreprise::class;
    }

    /**
     * Normalise le nom en remplaçant les caractères non alphabétiques par des tirets et translittère le résultat.
     *
     * @param mixed $name nom à normaliser
     *
     * @return string nom normalisé
     */
    protected function normalizeName($name): string
    {
        $name = str_replace('/[^a-z]+/', '-', $name);

        return $this->transliterator->transliterate($name);
    }

    /**
     * Génère une adresse e-mail en utilisant le nom normalisé.
     *
     * @return string adresse e-mail générée
     */
    protected function generateEmail($Name): string
    {
        $normalizedName = $this->normalizeName(strtr($Name, [' ' => '.']));

        return $normalizedName.'@'.self::faker()->domainName();
    }

    /**
     * Génère une URL pour le logo en utilisant des couleurs aléatoires et le nom de l'entreprise.
     *
     * @param string $Name nom de l'entreprise
     *
     * @return string URL du logo générée
     */
    protected function generateLogo(string $Name): string
    {
        $color1 = substr(self::faker()->hexColor(), 1);
        $color2 = substr(self::faker()->hexColor(), 1);

        return "https://placehold.co/500x500/$color1/$color2?text=$Name";
    }

    /**
     * Génère une URL pour le site web en utilisant le nom normalisé.
     *
     * @param string $Name nom de l'entreprise
     *
     * @return string URL du site web générée
     */
    protected function generateSiteWeb(string $Name): string
    {
        $normalizedName = $this->normalizeName(strtr($Name, [' ' => '']));

        return 'https://'.$normalizedName.'.'.self::faker()->domainName();
    }
}
