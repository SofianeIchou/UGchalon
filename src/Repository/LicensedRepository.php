<?php

namespace App\Repository;

use App\Entity\Licensed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Licensed|null find($id, $lockMode = null, $lockVersion = null)
 * @method Licensed|null findOneBy(array $criteria, array $orderBy = null)
 * @method Licensed[]    findAll()
 * @method Licensed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicensedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Licensed::class);
    }

    // /**
    //  * @return Licensed[] Returns an array of Licensed objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Licensed
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
