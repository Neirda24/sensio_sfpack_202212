<?php

namespace App\EventSubscriber;

use App\Repository\UserRepository;
use Symfony\Component\Clock\ClockInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class LastLoggedInUserSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ClockInterface $clock,
    ) {
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $this->userRepository->updateLastLogIn($event->getAuthenticationToken()->getUser(), $this->clock->now());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticationSuccessEvent::class => [
                ['onAuthenticationSuccess'],
            ],
        ];
    }
}
