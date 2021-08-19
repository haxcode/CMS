<?php

namespace App\Planing\Infrastructure\QueryHandler;

use App\Common\CQRS\QueryHandler;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use App\Common\Exception\NotFoundException;
use App\Planing\Application\Query\GetReleaseByUuid;
use App\User\Entity\ValueObject\Role;
use App\User\Security\AccessRoleHelper;
use App\Planing\Domain\Entity\Release;
use App\Common\Exception\Access\ObjectAccessException;

/**
 * Class DBALGetReleaseByUuidHandler
 *
 * @package          App\Planing\Infrastructure\QueryHandler
 * @createDate       2021-01-10
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class DBALGetReleaseByUuidHandler implements QueryHandler {

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
     * @param GetReleaseByUuid $query
     *
     * @return mixed
     * @throws Exception
     * @throws NotFoundException
     * @throws ObjectAccessException
     */
    public function __invoke(GetReleaseByUuid $query) {

        $data = $this->connection->createQueryBuilder()->select('release_id, version, codename, planed_release, release_note, released, release_date')->from('release')->where('release_id  = :uuid')->setParameter('uuid', (string)$query->getUuid())->execute()->fetchAllAssociative();
        if (empty($data) || !isset($data[0])) {
            throw new NotFoundException('Release with this uuid was not found');
        }
        $data = $data[0];

        if (!AccessRoleHelper::hasRole($query->getUser(), Role::ADMIN) && !$data['released']) {
            throw new ObjectAccessException(Release::class, 'Access deny. Only administrator can read unreleased Release');
        }

        return $data;
    }

}