<?php

namespace App\Dictionary\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use App\Dictionary\Entity\Change;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Dictionary\Entity\Component;

class ComponentRepository extends ServiceEntityRepository {

    /**
     * ComponentRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Component::class);
    }

    /**
     * @param Component $component
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Component $component): void {
        $this->_em->persist($component);
        $this->_em->flush();
    }

    /**
     * @param Component $component
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Component $component): void {
        $this->_em->persist($component);
        $this->_em->flush();
    }

    /**
     * @param Uuid $id
     *
     * @return Component|null
     * @throws NonUniqueResultException
     */
    public function get(Uuid $id): ?Component {
        $component = $this->createQueryBuilder('c')->andWhere('c.id = :id')->setParameter('id', pg_escape_string($id))->getQuery()->getOneOrNullResult();
        if ($component == NULL)
            return NULL;

        return $component;
    }

    /**
     * @param Uuid $uuid
     *
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Uuid $uuid): void {
        $component = $this->get($uuid);
        if ($component == NULL) {
            throw new NotFoundHttpException('Component with this uuid was not found', NULL, 404);
        }
        $this->_em->remove($component);
        $this->_em->flush();
    }

}