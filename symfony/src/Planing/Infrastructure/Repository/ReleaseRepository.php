<?php

namespace App\Planing\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Planing\Domain\Entity\Release;
use App\Planing\Domain\ValueObject\VersionType;

class ReleaseRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Release::class);
    }

    public function create(Release $release): void {
        $this->_em->persist($release);
        $this->_em->flush();
    }

    public function update(Release $release): void {
        $this->_em->persist($release);
        $this->_em->flush();
    }

    public function findLastReleased(VersionType $versionType) {
        $data = $this->createQueryBuilder('release')->select('r.version')->from('release', 'r')->where('released')->orderBy('release_date','DESC')
            ->getFirstResult();
        return $data;
    }

}