<?php

namespace App\Event;

use App\Entity\User;
use App\ReadModel\Movie;
use Symfony\Contracts\EventDispatcher\Event;

class UnderagedMovieAccess extends Event
{
    public function __construct(
        public readonly Movie $movie,
        public readonly User  $user,
    ) {
    }
}
