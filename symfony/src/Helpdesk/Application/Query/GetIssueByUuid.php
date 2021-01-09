<?php

namespace App\Helpdesk\Application\Query;

use App\Common\CQRS\Query;
use Symfony\Component\Uid\Uuid;

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
    private int  $questioningUser;

    /**
     * ClientsListQuery constructor.
     *
     * @param Uuid $uuid
     * @param int  $questioningUser
     */
    public function __construct(Uuid $uuid, int $questioningUser) {

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
     * @return int
     */
    public function getQuestioningUser(): int {
        return $this->questioningUser;
    }

}