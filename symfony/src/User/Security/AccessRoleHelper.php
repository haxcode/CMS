<?php

namespace App\User\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class AccessRoleHelper {

    /**
     * @param UserInterface|null $user
     * @param string             $group
     *
     * @return bool
     */
    public static function hasRole(?UserInterface $user, string $group): bool {
        if ($user == NULL) {
            return false;
        }
        return in_array($group, $user->getRoles());
    }

}