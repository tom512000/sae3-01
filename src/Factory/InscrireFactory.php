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
 * @method        Inscrire|Proxy                     create(array|callable $attributes = [])
 * @method static Inscrire|Proxy                     createOne(array $attributes = [])
 * @method static Inscrire|Proxy                     find(object|array|mixed $criteria)
 * @method static Inscrire|Proxy                     findOrCreate(array $attributes)
 * @method static Inscrire|Proxy                     first(string $sortedField = 'id')
 * @method static Inscrire|Proxy                     last(string $sortedField = 'id')
 * @method static Inscrire|Proxy                     random(array $attributes = [])
 * @method static Inscrire|Proxy                     randomOrCreate(array $attributes = [])
 * @method static InscrireRepository|RepositoryProxy repository()
 * @method static Inscrire[]|Proxy[]                 all()
 * @method static Inscrire[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Inscrire[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Inscrire[]|Proxy[]                 findBy(array $attributes)
 * @method static Inscrire[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Inscrire[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class InscrireFactory extends ModelFactory
{
    private OffreRepository $offreRepository;
    private userRepository $userRepository;

    /**
     * Constructeur de la factory.
     */
    public function __construct(OffreRepository $offreRepository, userRepository $userRepository)
    {
        parent::__construct();
        $this->offreRepository = $offreRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Définit les valeurs par défaut lors de la création d'une inscription.
     *
     * @return array tableau des valeurs par défaut
     */
    protected function getDefaults(): array
    {
        $existingOffresIds = $this->offreRepository->findOffresIds();
        $existingUsersIds = $this->userRepository->findUsersIds();

        $uniqueCombination = $this->getUniqueCombination($existingOffresIds, $existingUsersIds);

        return [
            'Status' => self::faker()->numberBetween(1, 3),
            'dateDemande' => self::faker()->dateTime(),
            'Offre' => $uniqueCombination['offre'],
            'User' => $uniqueCombination['user'],
        ];
    }

    /**
     * Méthode d'initialisation de la factory.
     *
     * @return InscrireFactory instance de la factory
     */
    protected function initialize(): self
    {
        return $this;
    }

    /**
     * Retourne la classe de l'entité gérée par la factory.
     *
     * @return string nom de la classe Inscrire
     */
    protected static function getClass(): string
    {
        return Inscrire::class;
    }

    /**
     * Génère une combinaison unique d'offre et d'utilisateur.
     *
     * @param array $offres liste des identifiants d'offres existantes
     * @param array $users  liste des identifiants d'utilisateurs existants
     *
     * @return array tableau associatif contenant une offre et un utilisateur
     */
    private function getUniqueCombination(array $offres, array $users): array
    {
        $offre = self::faker()->randomElement($offres);
        $user = self::faker()->randomElement($users);

        while (InscrireFactory::repository()->findOneBy(['Offre' => $offre, 'User' => $user])) {
            $offre = self::faker()->randomElement($offres);
            $user = self::faker()->randomElement($users);
        }

        return ['offre' => $offre, 'user' => $user];
    }
}
