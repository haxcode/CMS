<?php

namespace App\Planing\Application\Query;

use Symfony\Component\Security\Core\User\UserInterface;
use App\Common\CQRS\Query;

class GetReleases implements Query {

    /**
     * @var UserInterface
     */
    private UserInterface $user;

    /**
     * GetReleases constructor.
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user) {
        $this->user = $user;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface {
        return $this->user;
    }

}