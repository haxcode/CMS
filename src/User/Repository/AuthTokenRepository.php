<?php

namespace App\User\Repository;

use App\User\Entity\AuthToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AuthToken|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method AuthToken|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method AuthToken[]    findAll()
 * @method AuthToken[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class AuthTokenRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, AuthToken::class);
    }

}
