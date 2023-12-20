<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;

final class UserFactory extends ModelFactory
{
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * Constructeur de la factory.
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Définit les valeurs par défaut lors de la création d'un User.
     *
     * @return array tableau des valeurs par défaut
     */
    protected function getDefaults(): array
    {
        return [
            'dateNais' => self::faker()->dateTime,
            'email' => self::faker()->email(),
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
            'password' => 'test',
            'phone' => self::faker()->phoneNumber(),
            'roles' => [],
            'status' => 1,
        ];
    }

    /**
     * Méthode d'initialisation de la factory.
     *
     * @return UserFactory instance de la factory
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (User $user) {
                $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            })
        ;
    }

    /**
     * Retourne la classe de l'entité gérée par la factory.
     *
     * @return string nom de la classe User
     */
    protected static function getClass(): string
    {
        return User::class;
    }
}
