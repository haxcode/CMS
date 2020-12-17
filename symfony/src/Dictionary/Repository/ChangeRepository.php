<?php

namespace App\Dictionary\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use App\Dictionary\Entity\Change;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Uid\Uuid;

class ChangeRepository extends ServiceEntityRepository {

    /**
     * ChangeRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Change::class);
    }

    /**
     * @param Change $change
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Change $change): void {
        $this->_em->persist($change);
        $this->_em->flush();
    }

    /**
     * @param Change $change
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Change $change): void {
        $this->_em->persist($change);
        $this->_em->flush();
    }

    /**
     * @param Uuid $id
     *
     * @return Change|null
     * @throws NonUniqueResultException
     */
    public function get(Uuid $id): ?Change {
        $data = $this->createQueryBuilder('c')->andWhere('c.id = :id')->setParameter('id', pg_escape_string($id))->getQuery()->getOneOrNullResult();
        if ($data == NULL)
            return NULL;

        return $data;
    }

}