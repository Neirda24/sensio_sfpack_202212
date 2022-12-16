<?php

namespace App\EventSubscriber;

use App\Event\UnderagedMovieAccess;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use function dump;

class UserAccessSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function onUnderagedAccess(UnderagedMovieAccess $event): void
    {
        $adminList = $this->userRepository->listAdmins();

        dump($adminList);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UnderagedMovieAccess::class => [
                ['onUnderagedAccess'],
            ],
        ];
    }
}
