<?php

namespace App\Dictionary\Service;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Common\Service\TServiceParameterValidator;
use App\Dictionary\Repository\ADRRepository;
use App\Dictionary\Entity\ArchitectureDecisionRecord;
use App\User\Security\AccessRoleHelper;
use App\User\Entity\ValueObject\Role;
use App\Common\Exception\Access\ObjectAccessException;
use App\Common\Exception\Services\ServiceParameterRequiredException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use App\Common\Exception\Services\ServiceTypeParameterException;
use App\Common\Exception\Services\NotSupportedServiceParameterException;

/**
 * Class ADRService
 *
 * @package          App\Dictionary\Service
 * @createDate       2021-01-11
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
class ADRService {

    use TServiceParameterValidator;

    /**
     * @var ADRRepository
     */
    private ADRRepository $repository;

    /**
     * ADRService constructor.
     *
     * @param ADRRepository $repository
     */
    public function __construct(ADRRepository $repository) {
        $this->serviceName = 'ArchitectureDecisionRecordService';
        $this->repository = $repository;
    }

    /**
     * @param array         $data
     * @param UserInterface $user
     *
     * @return Uuid
     * @throws ObjectAccessException
     * @throws NotSupportedServiceParameterException
     * @throws ServiceParameterRequiredException
     * @throws ServiceTypeParameterException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createADR(array $data, UserInterface $user): Uuid {
        if (!AccessRoleHelper::hasRole($user, Role::ADMIN)) {
            throw new ObjectAccessException(ArchitectureDecisionRecord::class, 'Access deny! Only administrator can create architecture decision record.');
        }
        $this->validate($data, [
            'title'       => 'required|text',
            'description' => 'required|text',
            'result'      => 'required|text',
            'change_uuid' => 'uuid',
        ]);
        $uuid = Uuid::v4();

        $adr = new ArchitectureDecisionRecord($uuid, $data['title']);
        if (isset($data['description'])) {
            $adr->setDescription($data['description']);
        }
        if (isset($data['result'])) {
            $adr->setResult($data['result']);
        }
        if (isset($data['change_uuid'])) {
            $adr->setChange(new Uuid($data['change_uuid']));
        }

        $this->repository->create($adr);

        return $uuid;
    }

    /**
     * @param array         $data
     * @param UserInterface $user
     *
     * @return Uuid
     * @throws ObjectAccessException
     * @throws NotSupportedServiceParameterException
     * @throws ServiceParameterRequiredException
     * @throws ServiceTypeParameterException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateADR(array $data, UserInterface $user): void {
        if (!AccessRoleHelper::hasRole($user, Role::ADMIN)) {
            throw new ObjectAccessException(ArchitectureDecisionRecord::class, 'Access deny! Only administrator can modify architecture decision record.');
        }
        $this->validate($data, [
            'uuid'        => 'required|uuid',
            'title'       => 'text',
            'description' => 'text',
            'result'      => 'text',
            'change_uuid' => 'uuid',
        ]);
        $adr = $this->getADR(new Uuid($data['uuid']));

        if (isset($data['title'])) {
            $adr->setTitle($data['title']);
        }
        if (isset($data['description'])) {
            $adr->setDescription($data['description']);
        }
        if (isset($data['result'])) {
            $adr->setResult($data['result']);
        }
        if (isset($data['change_uuid'])) {
            $adr->setChange(new Uuid($data['change_uuid']));
        }

        $this->repository->update($adr);

    }

    /**
     * @param Uuid $uuid
     *
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws \App\Common\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function deleteADR(Uuid $uuid): void {
        $this->repository->delete($uuid);
    }

    /**
     * @param Uuid $uuid
     *
     * @return ArchitectureDecisionRecord
     * @throws \App\Common\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getADR(Uuid $uuid): ArchitectureDecisionRecord {
        return $this->repository->get($uuid);
    }

    /**
     * @return array
     */
    public function getAll(): array {
        return $this->repository->findAll();

    }

}