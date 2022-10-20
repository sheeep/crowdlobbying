<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\EventDispatcher\GenericEvent;

class UserRoleListener
{
    public function __invoke(GenericEvent $event): void
    {
        $user = $event->getSubject();

        if (!$user instanceof User) {
            return;
        }

        $roles = $user->getRoles();
        $roles[] = 'ROLE_CAMPAIGN_MANAGER';

        $user->setRoles(array_unique($roles));
    }
}
