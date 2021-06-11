<?php

namespace App\Repository;

use App\Entity\PerimetreElectricite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PerimetreElectricite|null find($id, $lockMode = null, $lockVersion = null)
 * @method PerimetreElectricite|null findOneBy(array $criteria, array $orderBy = null)
 * @method PerimetreElectricite[]    findAll()
 * @method PerimetreElectricite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PerimetreElectriciteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PerimetreElectricite::class);
    }
    public function findByPerimElec($client, $segmamtation)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.client = :client')
            ->andWhere('p.segmentation = :segmentation')
            ->setParameter('client', $client)
            ->setParameter('segmentation', $segmamtation)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return PerimetreElectricite[] Returns an array of PerimetreElectricite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PerimetreElectricite
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
