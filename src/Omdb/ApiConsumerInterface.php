<?php

declare(strict_types=1);

namespace App\Omdb;

interface ApiConsumerInterface
{
    /**
     * @return array{
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
     * }
     */
    public function getById(string $imdbId): array;
}
