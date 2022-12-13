<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    private const MOVIES = [
        'avatar'                              => [
            'title'      => 'Avatar',
            'releasedAt' => '16/12/2009',
            'genres'     => ['Action', 'Adventure', 'Fantasy'],
            'poster'     => '/avatar.jpg',
            'rated'      => 'PG-13',
        ],
        'asterix-et-obelix-mission-cleopatre' => [
            'title'      => 'Astérix et Obélix : Mission Cléopâtre',
            'releasedAt' => '30/01/2002',
            'genres'     => ['Documentary', 'Adventure', 'Comedy', 'Family'],
            'poster'     => '/mission-cleopatre.jpg',
            'rated'      => null,
        ],
    ];

    public function getDependencies(): array
    {
        return [
            GenreFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::MOVIES as $movieSlug => $movieDetails) {
            $movie = (new Movie())
                ->setTitle($movieDetails['title'])
                ->setSlug($movieSlug)
                ->setPoster($movieDetails['poster'])
                ->setReleasedAt(DateTimeImmutable::createFromFormat('d/m/Y', $movieDetails['releasedAt']));

            foreach ($movieDetails['genres'] as $genreName) {
                $movie->addGenre($this->getReference("genre.{$genreName}"));
            }
            $manager->persist($movie);
        }

        $manager->flush();
    }
}
