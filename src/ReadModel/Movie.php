<?php

namespace App\ReadModel;

use DateTimeImmutable;

class Movie
{
    /**
     * @param array<int, string> $genres
     */
    public function __construct(
        public readonly string            $title,
        public readonly DateTimeImmutable $releasedAt,
        public readonly array             $genres,
        public readonly string            $poster,
    ) {
    }
}
