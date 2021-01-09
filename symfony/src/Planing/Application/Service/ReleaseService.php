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
     */
    public function createRelease(array $data, UserInterface $user): Uuid {
        if (!AccessRoleHelper::hasRole($user, Role::ADMIN)) {
            throw new ObjectAccessException(Release::class, 'Access deny! Only Admin has access to create release.');
        }
        $this->validate($data, [
            'codename'     => 'required|text',
            'version_type' => 'required|text',
        ]);
        $uuid = Uuid::v4();
        $command = new CreateRelease($uuid, new VersionType($data['version_type']), $data['codename']);

        $this->commandBus->dispatch($command);
        return $uuid;

    }

}