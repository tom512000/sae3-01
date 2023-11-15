<?php

// src/Factory/UserFactory.php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;

final class UserFactory extends ModelFactory
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();

        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'dateNais' => self::faker()->date('d/m/Y'),
            'email' => self::faker()->email(),
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
            'password' => 'test',
            'phone' => self::faker()->phoneNumber(),
            'roles' => [],
            'status' => 1,
        ];
    }

    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function(User $user) {
                $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
    })
    ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}