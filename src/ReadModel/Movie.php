<?php

namespace App\ReadModel;

use App\Entity\Genre as GenreEntity;
use App\Entity\Movie as MovieEntity;
use DateTimeImmutable;
use function array_map;

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
    ) {
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
            array_map(static fn (GenreEntity $genre): string => $genre->getName(), $movieEntity->getGenres()->toArray()),
            $movieEntity->getPoster(),
        );
    }
}
