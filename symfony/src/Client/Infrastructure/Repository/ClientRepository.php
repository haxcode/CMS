<?php

namespace App\Client\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Client\Domain\Entity\Client;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Uid\Uuid;

/**
 * @method Client|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Client|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class ClientRepository extends ServiceEntityRepository {

    /**
     * ClientRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Client::class);
    }

    // /**
    //  * @return Client[] Returns an array of Client objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param Client $client
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Client $client): void {
        $this->_em->persist($client);
        $this->_em->flush();
    }

    /**
     * @param string $nip
     *
     * @return Client|null
     * @throws NonUniqueResultException
     */
    public function findByNIP(string $nip): ?Client {
        $entity = $this->createQueryBuilder('c')->andWhere('c.nip = :nip')->setParameter('nip', pg_escape_string($nip))->getQuery()->getOneOrNullResult();
        if ($entity == NULL)
            return NULL;

        return $entity;
    }

    /**
     * @param Uuid $uuid
     *
     * @return Client
     * @throws ClientNotFoundException
     */
    public function getByUuid(Uuid $uuid): Client {
        $client = $this->find($uuid);
        if ($client == null)
            throw new ClientNotFoundException("Client with this ID not exist");

        return $client;

    }

}
