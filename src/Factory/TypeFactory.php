<?php

namespace App\Factory;

use App\Entity\Type;
use App\Repository\TypeRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Type>
 *
 * @method        Type|Proxy                     create(array|callable $attributes = [])
 * @method static Type|Proxy                     createOne(array $attributes = [])
 * @method static Type|Proxy                     find(object|array|mixed $criteria)
 * @method static Type|Proxy                     findOrCreate(array $attributes)
 * @method static Type|Proxy                     first(string $sortedField = 'id')
 * @method static Type|Proxy                     last(string $sortedField = 'id')
 * @method static Type|Proxy                     random(array $attributes = [])
 * @method static Type|Proxy                     randomOrCreate(array $attributes = [])
 * @method static TypeRepository|RepositoryProxy repository()
 * @method static Type[]|Proxy[]                 all()
 * @method static Type[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Type[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Type[]|Proxy[]                 findBy(array $attributes)
 * @method static Type[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Type[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class TypeFactory extends ModelFactory
{
    /**
     * Constructeur de la factory.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Définit les valeurs par défaut lors de la création d'un Type.
     *
     * @return array tableau des valeurs par défaut
     */
    protected function getDefaults(): array
    {
        return [
            'libelle' => self::faker()->word(),
        ];
    }

    /**
     * Méthode d'initialisation de la factory.
     *
     * @return TypeFactory instance de la factory
     */
    protected function initialize(): self
    {
        return $this;
    }

    /**
     * Retourne la classe de l'entité gérée par la factory.
     *
     * @return string nom de la classe Type
     */
    protected static function getClass(): string
    {
        return Type::class;
    }
}
