<?php

namespace App\Helpdesk\Infrastructure\QueryHandler;

use App\Common\CQRS\QueryHandler;
use Doctrine\DBAL\Connection;
use App\Helpdesk\Application\Query\GetIssueByUuid;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Driver\ResultStatement;
use App\Common\Exception\NotFoundException;
use App\User\Security\AccessRoleHelper;
use App\User\Entity\ValueObject\Role;
use App\Common\Exception\Access\ObjectAccessException;
use App\Helpdesk\Domain\Entity\Issue;

/**
 * Class DBALGetIssueByUuidHandler
 *
 * @package          App\Helpdesk\Infrastructure\QueryHandler
 * @createDate       2021-01-06
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class DBALGetIssueByUuidHandler implements QueryHandler {

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * DBALGetIssueByUuidHandler constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    /**
     * @param GetIssueByUuid $query
     *
     * @return ResultStatement|int
     * @throws Exception
     */
    public function __invoke(GetIssueByUuid $query) {
        $data = $this->connection->createQueryBuilder()->select('issue_id, client_id, title, description, add_date, last_modify_date, solve_date, solved, author, last_modifier, author, importance, is_confidential, component_uuid, withdrawn ')->from('issue')->where('issue_id = :uuid')->setParameter('uuid', (string)$query->getUuid())->execute()->fetchAllAssociative();
        if (empty($data)) {
            throw new NotFoundException("Issue with specified identity not found");
        }
        if ($data[0]['is_confidential'] && $data[0]['author'] != $query->getQuestioningUser()->getId() && !AccessRoleHelper::hasRole($query->getQuestioningUser(), Role::ADMIN)) {
            throw new ObjectAccessException(Issue::class, "This issue is confidential you dont have permission to read!");
        }
        return $data[0];
    }

}