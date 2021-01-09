<?php

namespace App\Helpdesk\Infrastructure\QueryHandler;

use App\Common\CQRS\QueryHandler;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use App\User\Security\AccessRoleHelper;
use App\User\Entity\ValueObject\Role;
use App\Helpdesk\Application\Query\GetIssues;

/**
 * Class DBALGetIssuesHandler
 *
 * @package          App\Helpdesk\Infrastructure\QueryHandler
 * @createDate       2021-01-09
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class DBALGetIssuesHandler implements QueryHandler {

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * DBALGetIssuesHandler constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    /**
     * @param GetIssues $query
     *
     * @return mixed
     * @throws Exception
     */
    public function __invoke(GetIssues $query) {

        $queryBuilder = $this->connection->createQueryBuilder()->select('issue_id, client_id, title, description, add_date, last_modify_date, solve_date, solved, author, last_modifier, author, importance, is_confidential, component_uuid, withdrawn')->from('issue');

        if (!AccessRoleHelper::hasRole($query->getQuestioningUser(), Role::ADMIN)) {
            $queryBuilder->where(' NOT withdrawn AND (NOT is_confidential OR author = :author)')->setParameter('author', (string)$query->getQuestioningUser()
                ->getId());
        }

        return $queryBuilder->execute()->fetchAllAssociative();
    }

}