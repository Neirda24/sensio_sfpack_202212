<?php

namespace App\Service;

use App\ReadModel\Movie;
use DateTimeImmutable;
use function array_map;

class Movies
{
    private const MOVIES = [
        'avatar'                              => [
            'title'      => 'Avatar',
            'releasedAt' => '16/12/2009',
            'genres'     => ['Action', 'Adventure', 'Fantasy'],
        ],
        'asterix-et-obelix-mission-cleopatre' => [
            'title'      => 'Astérix et Obélix : Mission Cléopâtre',
            'releasedAt' => '30/01/2002',
            'genres'     => ['Documentary', 'Adventure', 'Comedy', 'Family'],
        ],
    ];

    public static function getMovies(): array
    {
        return array_map(self::createMovieFromMovieDetails(...), self::MOVIES);
    }

    public static function findOneBySlug(string $slug): Movie
    {
        return self::createMovieFromMovieDetails(self::MOVIES[$slug]);
    }

    private static function createMovieFromMovieDetails(array $movieDetails): Movie
    {
        return new Movie(
            $movieDetails['title'],
            DateTimeImmutable::createFromFormat('d/m/Y', $movieDetails['releasedAt']),
            $movieDetails['genres'],
        );
    }
}
