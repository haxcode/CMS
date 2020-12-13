<?php

namespace App\User\Repository;

use App\User\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\NonUniqueResultException;
use function get_class;

/**
 * @method User|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method User|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param string $email
     *
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findByEmail(string $email): ?User {
        return $this->createQueryBuilder('u')->andWhere('u.email = :email')->setParameter('email', $email)->getQuery()->getOneOrNullResult();
    }

    /**
     * @param string $token
     *
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findByToken(string $token): ?User {
        return $this->createQueryBuilder('u')->andWhere('u.id = (SELECT t.userId FROM App\User\Entity\AuthToken t WHERE t.token = :token )')->setParameter('token', $token)->getQuery()->getOneOrNullResult();
    }




    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
