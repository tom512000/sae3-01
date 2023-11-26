<?php

namespace App\Factory;

use App\Entity\Skill;
use App\Repository\SkillRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Skill>
 *
 * @method        Skill|Proxy create(array|callable $attributes = [])
 * @method static Skill|Proxy createOne(array $attributes = [])
 * @method static Skill|Proxy find(object|array|mixed $criteria)
 * @method static Skill|Proxy findOrCreate(array $attributes)
 * @method static Skill|Proxy first(string $sortedField = 'id')
 * @method static Skill|Proxy last(string $sortedField = 'id')
 * @method static Skill|Proxy random(array $attributes = [])
 * @method static Skill|Proxy randomOrCreate(array $attributes = [])
 * @method static SkillRepository|RepositoryProxy repository()
 * @method static Skill[]|Proxy[] all()
 * @method static Skill[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Skill[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Skill[]|Proxy[] findBy(array $attributes)
 * @method static Skill[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Skill[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class SkillFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'libelle' => self::faker()->text(100),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Skill $skill): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Skill::class;
    }
}
