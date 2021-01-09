<?php

namespace App\Helpdesk\Application\Query;

use App\Common\CQRS\Query;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class GetIssueByUuid
 *
 * @package          App\Helpdesk\Application\Query
 * @createDate       2021-01-06
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class GetIssueByUuid implements Query {

    /**
     * @var Uuid
     */
    private Uuid $uuid;
    private UserInterface  $questioningUser;

    /**
     * GetIssueByUuid constructor.
     *
     * @param Uuid          $uuid
     * @param UserInterface $questioningUser
     */
    public function __construct(Uuid $uuid, UserInterface $questioningUser) {

        $this->uuid = $uuid;
        $this->questioningUser = $questioningUser;
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
    public function getQuestioningUser(): UserInterface {
        return $this->questioningUser;
    }

}