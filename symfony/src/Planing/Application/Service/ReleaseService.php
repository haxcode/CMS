<?php

namespace App\Planing\Application\Service;

use App\Common\CQRS\CommandBus;
use Symfony\Component\Uid\Uuid;
use App\Common\Service\TServiceParameterValidator;
use App\Planing\Application\Command\CreateRelease;
use App\Planing\Domain\ValueObject\VersionType;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Common\Exception\Services\ServiceTypeParameterException;
use App\Common\Exception\Services\ServiceParameterRequiredException;
use App\Common\Exception\Services\NotSupportedServiceParameterException;
use App\Common\Exception\NotSupportedType;
use App\User\Security\AccessRoleHelper;
use App\User\Entity\ValueObject\Role;
use App\Common\Exception\Access\ObjectAccessException;
use App\Planing\Domain\Entity\Release;
use DateTime;
use App\Planing\Application\Command\UpdateRelease;

class ReleaseService {

    use TServiceParameterValidator;

    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus) {
        $this->serviceName = 'ReleaseService';
        $this->commandBus = $commandBus;
    }

    /**
     * @param array         $data
     * @param UserInterface $user
     *
     * @return Uuid
     * @throws NotSupportedServiceParameterException
     * @throws NotSupportedType
     * @throws ObjectAccessException
     * @throws ServiceParameterRequiredException
     * @throws ServiceTypeParameterException
     * @throws \Exception
     */
    public function createRelease(array $data, UserInterface $user): Uuid {
        if (!AccessRoleHelper::hasRole($user, Role::ADMIN)) {
            throw new ObjectAccessException(Release::class, 'Access deny! Only Admin has access to create release.');
        }
        $this->validate($data, [
            'codename'       => 'required|text',
            'version_type'   => 'required|text',
            'planed_release' => 'text',
        ]);
        $uuid = Uuid::v4();
        $date = null;
        if (isset($data['planed_release'])) {
            $date = new DateTime($data['planed_release']);
        }
        $command = new CreateRelease($uuid, new VersionType($data['version_type']), $data['codename'], $date);

        $this->commandBus->dispatch($command);
        return $uuid;

    }

    /**
     * @param array         $data
     * @param UserInterface $user
     *
     * @throws NotSupportedServiceParameterException
     * @throws ObjectAccessException
     * @throws ServiceParameterRequiredException
     * @throws ServiceTypeParameterException
     */
    public function updateRelease(array $data, UserInterface $user): void {
        if (!AccessRoleHelper::hasRole($user, Role::ADMIN)) {
            throw new ObjectAccessException(Release::class, 'Access deny! Only Admin has access to create release.');
        }
        $this->validate($data, [
            'release_id'     => 'uuid',
            'codename'       => 'text',
            'planed_release' => 'text',
            'release_note'   => 'text',
        ]);

        $this->commandBus->dispatch(new UpdateRelease($data, $user));

    }

}