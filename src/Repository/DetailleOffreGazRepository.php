<?php

namespace App\Repository;

use App\Entity\DetailleOffreGaz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailleOffreGaz|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailleOffreGaz|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailleOffreGaz[]    findAll()
 * @method DetailleOffreGaz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailleOffreGazRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailleOffreGaz::class);
    }

    // /**
    //  * @return DetailleOffreGaz[] Returns an array of DetailleOffreGaz objects
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
    public function findOneBySomeField($value): ?DetailleOffreGaz
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
