<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\PersonArgument;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PersonArgumentVoter extends Voter
{
    protected function supports($attribute, $subject): bool
    {
        if ($attribute !== 'ADMIN_MANAGE_PERSON_ARGUMENT') {
            return false;
        }

        if (!$subject instanceof PersonArgument) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();

        /** @var PersonArgument $argument */
        $argument = $subject;

        $search = $argument->getCampaign()->getCampaignManagers()->filter(function (User $manager) use ($user): bool {
            return $manager->getId() === $user->getId();
        });

        return $search->count() > 0;
    }
}
