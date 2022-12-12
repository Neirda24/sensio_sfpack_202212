<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $avatar = (new Movie())
            ->setTitle('Avatar')
            ->setSlug('avatar')
            ->setPoster('/avatar.jpg')
            ->setReleasedAt(DateTimeImmutable::createFromFormat('d/m/Y', '16/12/2009'))
        ;
        $manager->persist($avatar);

        $missionCleopatre = (new Movie())
            ->setTitle('Astérix et Obélix : Mission Cléopâtre')
            ->setSlug('asterix-et-obelix-mission-cleopatre')
            ->setPoster('/mission-cleopatre.jpg')
            ->setReleasedAt(DateTimeImmutable::createFromFormat('d/m/Y', '30/01/2002'))
        ;
        $manager->persist($missionCleopatre);

        $manager->flush();
    }
}
