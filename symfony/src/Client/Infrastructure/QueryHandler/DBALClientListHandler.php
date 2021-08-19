<?php

namespace App\Client\Infrastructure\QueryHandler;

use App\Common\CQRS\QueryHandler;
use Doctrine\DBAL\Connection;
use App\Client\Application\Query\ClientsList;

class DBALClientListHandler implements QueryHandler {

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * DBALClientListHandler constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection) {

        $this->connection = $connection;
    }

    public function __invoke(ClientsList $clientsList) {
        return $this->connection->createQueryBuilder()->select('id', 'nip', 'name', 'short_name', 'sla')->from('client')->orderBy('name')->execute();
    }

}