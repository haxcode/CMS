<?php

namespace App\Planing\Infrastructure\QueryHandler;

use App\Common\CQRS\QueryHandler;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use App\Common\Exception\NotFoundException;
use App\Common\Exception\Access\ObjectAccessException;
use App\Planing\Application\Query\GetTaskByUuid;
use App\User\Security\AccessRoleHelper;
use App\User\Entity\ValueObject\Role;
use App\Planing\Domain\Entity\Task;
use App\Planing\Application\Query\GetAssignedTasks;
use App\Planing\Application\Query\GetAuthoredTasks;

/**
 * Class DBALGetAuthoredTasksHandler
 *
 * @package          App\Planing\Infrastructure\QueryHandler
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class DBALGetAuthoredTasksHandler implements QueryHandler {

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * DBALGetAuthoredTasksHandler constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    /**
     * @param GetAuthoredTasks $query
     *
     * @return mixed
     * @throws Exception
     */
    public function __invoke(GetAuthoredTasks $query) {
        $data = $this->connection->createQueryBuilder()->select('task_id, description, assigned, state, client_id, note, related_to, estimated_time, spend_time, add_date, last_modify_date, done_date, done, author, last_modifier')
            ->from('task')
            ->where('author = :user_id')
            ->setParameter('user_id', $query->getUser()->getId())
            ->execute()
            ->fetchAllAssociative();
        return $data;

     
    }

}