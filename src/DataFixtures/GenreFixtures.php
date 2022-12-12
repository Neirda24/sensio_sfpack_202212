<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $action = (new Genre())->setName('Action');
        $manager->persist($action);

        $action = (new Genre())->setName('Adventure');
        $manager->persist($action);

        $action = (new Genre())->setName('Fantasy');
        $manager->persist($action);

        $manager->flush();
    }
}
