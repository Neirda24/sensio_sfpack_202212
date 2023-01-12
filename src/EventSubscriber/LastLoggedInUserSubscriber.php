<?php

namespace App\EventSubscriber;

use App\Repository\UserRepository;
use Symfony\Component\Clock\ClockInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LastLoggedInUserSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ClockInterface $clock,
    ) {
    }

    public function onAuthenticationSuccess(LoginSuccessEvent $event): void
    {
        $this->userRepository->updateLastLogIn(
            $event->getAuthenticatedToken()->getUser(),
            $this->clock->now(),
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => [
                ['onAuthenticationSuccess'],
            ],
        ];
    }
}
