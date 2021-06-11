<?php

namespace App\Repository;

use App\Entity\DetailOffreElec;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailOffreElec|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailOffreElec|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailOffreElec[]    findAll()
 * @method DetailOffreElec[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailOffreElecRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailOffreElec::class);
    }

    // /**
    //  * @return DetailOffreElec[] Returns an array of DetailOffreElec objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailOffreElec
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
