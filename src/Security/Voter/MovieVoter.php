<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\ReadModel\Movie;
use Symfony\Component\Clock\ClockInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MovieVoter extends Voter
{
    public const VIEW_DETAILS = 'VIEW_MOVIE_DETAILS';

    public function __construct(
        private readonly ClockInterface $clock,
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === self::VIEW_DETAILS
               && $subject instanceof Movie;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if (!$subject instanceof Movie) {
            return false;
        }

        $minAgeRequired = $subject->getMinAgeBasedOnRating();

        if (0 === $minAgeRequired) {
            return true;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        return $user->isOlderThan(
            $minAgeRequired,
            $this->clock->now(),
        );
    }
}
