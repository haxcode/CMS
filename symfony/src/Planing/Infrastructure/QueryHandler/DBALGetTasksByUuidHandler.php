<?php

namespace App\Planing\Infrastructure\QueryHandler;

use App\Common\CQRS\QueryHandler;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use App\Common\Exception\NotFoundException;
use App\Common\Exception\Access\ObjectAccessException;
use App\Planing\Application\Query\GetTasksByIssueUuid;
use App\Planing\Application\Query\GetTaskByUuid;
use App\User\Security\AccessRoleHelper;
use App\User\Entity\ValueObject\Role;
use App\Planing\Domain\Entity\Task;

/**
 * Class DBALGetTasksByUuidHandler
 *
 * @package          App\Planing\Infrastructure\QueryHandler
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class DBALGetTasksByUuidHandler implements QueryHandler {

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * DBALGetTasksByUuidHandler constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    /**
     * @param GetTaskByUuid $query
     *
     * @return mixed
     * @throws Exception
     * @throws NotFoundException
     * @throws ObjectAccessException
     */
    public function __invoke(GetTaskByUuid $query) {

        $data = $this->connection->createQueryBuilder()->select('task_id, description, assigned, state, client_id, note, related_to, estimated_time, spend_time, add_date, last_modify_date, done_date, done, author, last_modifier')->from('task')->where('task_id  = :uuid')->setParameter('uuid', (string)$query->getUuid())->execute()->fetchAllAssociative();
        if (empty($data) || !isset($data[0])) {
            throw new NotFoundException('Task with this uuid was not found');
        }
        $data = $data[0];

        if (!AccessRoleHelper::hasRole($query->getUser(), Role::ADMIN) && ($query->getUser()->getId() != $data['author']) && ($query->getUser()->getId() != $data['assigned'])) {
            throw new ObjectAccessException(Task::class, 'Access deny. This is not your task!');
        }

        return $data;
    }

}