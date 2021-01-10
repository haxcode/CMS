<?php

namespace App\Planing\Infrastructure\QueryHandler;

use App\Common\CQRS\QueryHandler;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use App\Planing\Application\Query\GetReleases;
use App\User\Security\AccessRoleHelper;
use App\User\Entity\ValueObject\Role;

/**
 * Class DBALGetReleasesHandler
 *
 * @package          App\Planing\Infrastructure\QueryHandler
 * @createDate       2021-01-10
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class DBALGetReleasesHandler implements QueryHandler {

    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * DBALGetTasksHandler constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    /**
     * @param GetReleases $query
     *
     * @return mixed
     * @throws Exception
     */
    public function __invoke(GetReleases $query) {
        $queryBuilder = $this->connection->createQueryBuilder()->select('release_id, version, codename, planed_release, release_note, released, release_date')->from('release');
        if (!AccessRoleHelper::hasRole($query->getUser(), Role::ADMIN)) {
            $queryBuilder->where('released');
        }
        return $queryBuilder->execute()->fetchAllAssociative();

    }

}