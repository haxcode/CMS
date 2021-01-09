<?php

namespace App\Planing\Application\Query;

use App\Common\CQRS\Query;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;

class GetTasksByIssueUuid implements Query {

    /**
     * @var Uuid
     */
    private Uuid $uuid;
    /**
     * @var UserInterface
     */
    private UserInterface $user;

    /**
     * GetTasksByIssueUuid constructor.
     *
     * @param Uuid          $uuid
     * @param UserInterface $user
     */
    public function __construct(Uuid $uuid, UserInterface $user) {
        $this->uuid = $uuid;
        $this->user = $user;
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