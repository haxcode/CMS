<?php

namespace App\Planing\Application\Query;

use App\Common\CQRS\Query;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;

class GetReleaseByUuid implements Query {

    /**
     * @var UserInterface
     */
    private UserInterface $user;
    /**
     * @var Uuid
     */
    private Uuid $uuid;

    /**
     * GetReleaseByUuid constructor.
     *
     * @param Uuid          $uuid
     * @param UserInterface $user
     */
    public function __construct(Uuid $uuid, UserInterface $user) {

        $this->user = $user;
        $this->uuid = $uuid;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid {
        return $this->uuid;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface {
        return $this->user;
    }

}