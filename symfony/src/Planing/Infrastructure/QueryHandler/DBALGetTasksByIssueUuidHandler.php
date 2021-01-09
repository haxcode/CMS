<?php

namespace App\Planing\Infrastructure\QueryHandler;

use App\Common\CQRS\QueryHandler;
use Doctrine\DBAL\Connection;
use App\Helpdesk\Application\Query\GetIssueByUuid;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Driver\ResultStatement;
use App\Common\Exception\NotFoundException;
use App\User\Security\AccessRoleHelper;
use App\User\Entity\ValueObject\Role;
use App\Common\Exception\Access\ObjectAccessException;
use App\Planing\Application\Query\GetTasksByIssueUuid;
use App\Helpdesk\Domain\Entity\Issue;

/**
 * Class DBALGetTasksByIssueUuidHandler
 *
 * @package          App\Planing\Infrastructure\QueryHandler
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class DBALGetTasksByIssueUuidHandler implements QueryHandler {

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * DBALGetTasksByIssueUuidHandler constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    /**
     * @param GetTasksByIssueUuid $query
     *
     * @return mixed
     * @throws Exception
     * @throws NotFoundException
     * @throws ObjectAccessException
     */
    public function __invoke(GetTasksByIssueUuid $query) {
        $data = $this->connection->createQueryBuilder()->select('issue_id, client_id, title, description, add_date, last_modify_date, solve_date, solved, author, last_modifier, author, importance, is_confidential, component_uuid, withdrawn ')->from('issue')->where('issue_id = :uuid')->setParameter('uuid', (string)$query->getUuid())->execute()->fetchAllAssociative();
        if (empty($data)) {
            throw new NotFoundException("Issue with specified identity not exist");
        }
        if ($data[0]['is_confidential'] && $data[0]['author'] != $query->getUser()->getId() && !AccessRoleHelper::hasRole($query->getUser(), Role::ADMIN)) {
            throw new ObjectAccessException(Issue::class, "This issue is confidential you dont have permission to read issue tasks!");
        }

        $data = $this->connection->createQueryBuilder()
            ->select('task_id, description, assigned, state, client_id, note, related_to, estimated_time, spend_time, add_date, last_modify_date, done_date, done, author, last_modifier')
            ->from('task')
            ->where('related_to = :uuid')
            ->setParameter('uuid', (string)$query->getUuid())
            ->execute()
            ->fetchAllAssociative();
        return $data;
    }

}