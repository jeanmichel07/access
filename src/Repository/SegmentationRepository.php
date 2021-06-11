<?php

namespace App\Repository;

use App\Entity\Segmentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Segmentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Segmentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Segmentation[]    findAll()
 * @method Segmentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SegmentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Segmentation::class);
    }

    // /**
    //  * @return Segmentation[] Returns an array of Segmentation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Segmentation
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
