<?php

namespace App\Repository\Admin;

use App\Entity\Admin\Versioning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Versioning|null find($id, $lockMode = null, $lockVersion = null)
 * @method Versioning|null findOneBy(array $criteria, array $orderBy = null)
 * @method Versioning[]    findAll()
 * @method Versioning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VersioningRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Versioning::class);
    }

    // /**
    //  * @return Versioning[] Returns an array of Versioning objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Versioning
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
