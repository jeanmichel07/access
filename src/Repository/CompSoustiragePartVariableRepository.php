<?php

namespace App\Repository;

use App\Entity\CompSoustiragePartVariable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompSoustiragePartVariable|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompSoustiragePartVariable|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompSoustiragePartVariable[]    findAll()
 * @method CompSoustiragePartVariable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompSoustiragePartVariableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompSoustiragePartVariable::class);
    }

    // /**
    //  * @return CompSoustiragePartVariable[] Returns an array of CompSoustiragePartVariable objects
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
    public function findOneBySomeField($value): ?CompSoustiragePartVariable
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
