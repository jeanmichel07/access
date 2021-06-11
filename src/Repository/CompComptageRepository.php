<?php

namespace App\Repository;

use App\Entity\CompComptage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompComptage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompComptage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompComptage[]    findAll()
 * @method CompComptage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompComptageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompComptage::class);
    }

    // /**
    //  * @return CompComptage[] Returns an array of CompComptage objects
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
    public function findOneBySomeField($value): ?CompComptage
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
