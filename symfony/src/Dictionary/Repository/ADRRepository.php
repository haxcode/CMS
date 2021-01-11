<?php

namespace App\Dictionary\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Dictionary\Entity\ArchitectureDecisionRecord;
use App\Common\Exception\NotFoundException;

class ADRRepository extends ServiceEntityRepository {

    /**
     * ADRRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ArchitectureDecisionRecord::class);
    }

    /**
     * @param ArchitectureDecisionRecord $adr
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(ArchitectureDecisionRecord $adr): void {
        $this->_em->persist($adr);
        $this->_em->flush();
    }

    /**
     * @param ArchitectureDecisionRecord $adr
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(ArchitectureDecisionRecord $adr): void {
        $this->_em->persist($adr);
        $this->_em->flush();
    }

    /**
     * @param Uuid $id
     *
     * @return ArchitectureDecisionRecord|null
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function get(Uuid $id): ?ArchitectureDecisionRecord {
        $adr = $this->createQueryBuilder('c')->andWhere('c.id = :id')->setParameter('id', pg_escape_string($id))->getQuery()->getOneOrNullResult();
        if ($adr == NULL)
            throw new NotFoundException('Architecture decision record with this ID not exist');

        return $adr;
    }

    /**
     * @param Uuid $uuid
     *
     * @throws NonUniqueResultException
     * @throws NotFoundException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Uuid $uuid): void {
        $adr = $this->get($uuid);
        if ($adr == NULL) {
            throw new NotFoundHttpException('Architecture decision record with this uuid was not found', NULL, 404);
        }
        $this->_em->remove($adr);
        $this->_em->flush();
    }

}