<?php

namespace App\ReadModel;

use App\Entity\Genre;
use App\Entity\Genre as GenreEntity;
use App\Entity\Movie as MovieEntity;
use DateTimeImmutable;
use Symfony\Component\String\Slugger\SluggerInterface;
use function array_map;
use function explode;
use function str_starts_with;

class Movie
{
    /**
     * @param array<int, string> $genres
     */
    public function __construct(
        public readonly string            $slug,
        public readonly string            $title,
        public readonly DateTimeImmutable $releasedAt,
        public readonly array             $genres,
        public readonly string            $poster,
        public readonly ?string           $rated,
    ) {
    }

    public function isRemotePoster(): bool
    {
        return str_starts_with($this->poster, 'http');
    }

    /**
     * @param array<int, MovieEntity> $movieEntities
     *
     * @return array<int, self>
     */
    public static function fromEntities(array $movieEntities): array
    {
        return array_map(self::fromEntity(...), $movieEntities);
    }

    public static function fromEntity(MovieEntity $movieEntity): self
    {
        return new self(
            $movieEntity->getSlug(),
            $movieEntity->getTitle(),
            $movieEntity->getReleasedAt(),
            array_map(static fn(GenreEntity $genre): string => $genre->getName(), $movieEntity->getGenres()->toArray()),
            $movieEntity->getPoster(),
            $movieEntity->getRated(),
        );
    }

    /**
     * @param array{
     *     Title: string,
     *     Year: string,
     *     Rated: string,
     *     Released: string,
     *     Runtime: string,
     *     Genre: string,
     *     Director: string,
     *     Writer: string,
     *     Actors: string,
     *     Plot: string,
     *     Language: string,
     *     Country: string,
     *     Awards: string,
     *     Poster: string,
     *     Ratings: array<int, array{Source: string, Value: string}>,
     *     Metascore: string,
     *     imdbRating: string,
     *     imdbVotes: string,
     *     imdbId: string,
     *     Type: string,
     *     DVD: string,
     *     BoxOffice: string,
     *     Production: string,
     *     Website: string,
     *     Response: string
     * } $omdbApiResponse
     */
    public static function fromOmdbApi(array $omdbApiResponse, SluggerInterface $slugger): self
    {
        return new self(
            $slugger->slug($omdbApiResponse['Title']),
            $omdbApiResponse['Title'],
            new DateTimeImmutable($omdbApiResponse['Released']),
            explode(', ', $omdbApiResponse['Genre']),
            $omdbApiResponse['Poster'],
            ('N/A' === $omdbApiResponse['Rated']) ? null : $omdbApiResponse['Rated'],
        );
    }
}
