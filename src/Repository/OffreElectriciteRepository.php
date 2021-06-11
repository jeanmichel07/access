<?php

namespace App\Repository;

use App\Entity\OffreElectricite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OffreElectricite|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreElectricite|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreElectricite[]    findAll()
 * @method OffreElectricite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreElectriciteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreElectricite::class);
    }
    public function findFive($client)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.client = :client')
            ->setParameter('client', $client)
            ->orderBy('o.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;
    }
    public function findBySegmentation($segmentation, $client)
    {
        return $this->createQueryBuilder('o')
            ->where('o.segmentation = :segmentation')
            ->andWhere('o.client = :client')
            ->setParameter('segmentation', $segmentation)
            ->setParameter('client', $client)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return OffreElectricite[] Returns an array of OffreElectricite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OffreElectricite
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
