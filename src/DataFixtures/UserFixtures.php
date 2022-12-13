<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class UserFixtures extends Fixture
{
    private const USERS = [
        'child' => [
            'dateOfBirth' => '07/04/2015',
            'email'       => 'louise@example.com',
            'password'    => 'louise',
            'admin'       => false,
        ],
        'teen'  => [
            'dateOfBirth' => '19/07/2003',
            'email'       => 'max@example.com',
            'password'    => 'max',
            'admin'       => false,
        ],
        'adult' => [
            'dateOfBirth' => '11/09/1990',
            'email'       => 'adrien@example.com',
            'password'    => 'adrien',
            'admin'       => true,
        ],
    ];

    public function __construct(
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $userDetails) {
            $user = (new User())
                ->setEmail($userDetails['email'])
                ->setDateOfBirth(DateTimeImmutable::createFromFormat('d/m/Y', $userDetails['dateOfBirth']))
            ;
            $user->setPassword($this->passwordHasherFactory->getPasswordHasher($user)->hash($userDetails['password']));

            if (true === $userDetails['admin']) {
                $user->setRoles(['ROLE_ADMIN']);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
