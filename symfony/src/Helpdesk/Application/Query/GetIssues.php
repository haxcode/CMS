<?php

namespace App\Helpdesk\Application\Query;

use App\Common\CQRS\Query;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class GetIssues
 *
 * @package          App\Helpdesk\Application\Query
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class GetIssues implements Query {
    
    private UserInterface  $questioningUser;

    /**
     * GetIssueByUuid constructor.
     *
     * @param Uuid          $uuid
     * @param UserInterface $questioningUser
     */
    public function __construct(UserInterface $questioningUser) {
        $this->questioningUser = $questioningUser;
    }

    /**
     * @return UserInterface
     */
    public function getQuestioningUser(): UserInterface {
        return $this->questioningUser;
    }

}