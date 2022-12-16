<?php

namespace App\Omdb;

use App\Entity\Movie as MovieEntity;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use DateTimeImmutable;
use Doctrine\ORM\NoResultException;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\String\Slugger\SluggerInterface;
use function explode;

#[AsDecorator(ApiConsumerInterface::class)]
class AutoImportInDatabaseConsumer implements ApiConsumerInterface
{
    public function __construct(
        private readonly ApiConsumerInterface $apiConsumer,
        private readonly MovieRepository      $movieRepository,
        private readonly GenreRepository      $genreRepository,
        private readonly SluggerInterface     $slugger,
        private bool                          $autoImportEnabled = false,
    ) {
    }

    public function setAutoImport(bool $enabled): void
    {
        $this->autoImportEnabled = $enabled;
    }

    public function getById(string $imdbId): array
    {
        $result = $this->apiConsumer->getById($imdbId);

        if (false === $this->autoImportEnabled) {
            return $result;
        }

        $slug = $this->slugger->slug($result['Title']);

        try {
            $this->movieRepository->fetchOneBySlug($slug);
        } catch (NoResultException) {
            $movie = (new MovieEntity())
                ->setSlug($slug)
                ->setTitle($result['Title'])
                ->setReleasedAt(new DateTimeImmutable($result['Released']))
                ->setPoster($result['Poster']);

            foreach (explode(', ', $result['Genre']) as $genreName) {
                $movie->addGenre($this->genreRepository->getOrCreate($genreName));
            }

            $this->movieRepository->save($movie, true);
        }

        return $result;
    }
}
