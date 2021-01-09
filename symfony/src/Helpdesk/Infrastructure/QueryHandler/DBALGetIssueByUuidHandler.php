<?php

namespace App\Helpdesk\Infrastructure\QueryHandler;

use App\Common\CQRS\QueryHandler;
use Doctrine\DBAL\Connection;
use App\Helpdesk\Application\Query\GetIssueByUuid;

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
     * @return \Doctrine\DBAL\Driver\ResultStatement|int
     * @throws \Doctrine\DBAL\Exception
     */
    public function __invoke(GetIssueByUuid $query) {
        $data = $this->connection->createQueryBuilder()->select('issue_id, client_id, title, description, usr_id, importance, is_confidential, component_uuid')->from('issue')->where('issue_id = :uuid')->setParameter('uuid', (string)$query->getUuid())->execute();
        return $data;
    }

}