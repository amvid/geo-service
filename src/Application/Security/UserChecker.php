<?php

declare(strict_types=1);

namespace App\Application\Security;

use App\Application\Entity\User;
use App\Application\Exception\UserIsNotActiveException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    /**
     * @throws UserIsNotActiveException
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->isActive()) {
            throw new UserIsNotActiveException();
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}
