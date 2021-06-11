<?php

namespace App\Repository;

use App\Entity\CompSoustiragePartFixe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompSoustiragePartFixe|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompSoustiragePartFixe|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompSoustiragePartFixe[]    findAll()
 * @method CompSoustiragePartFixe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompSoustiragePartFixeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompSoustiragePartFixe::class);
    }

    // /**
    //  * @return CompSoustiragePartFixe[] Returns an array of CompSoustiragePartFixe objects
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
    public function findOneBySomeField($value): ?CompSoustiragePartFixe
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
