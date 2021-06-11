<?php

namespace App\Repository;

use App\Entity\CompGestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompGestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompGestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompGestion[]    findAll()
 * @method CompGestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompGestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompGestion::class);
    }

    // /**
    //  * @return CompGestion[] Returns an array of CompGestion objects
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
    public function findOneBySomeField($value): ?CompGestion
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
