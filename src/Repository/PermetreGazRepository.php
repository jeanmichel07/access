<?php

namespace App\Repository;

use App\Entity\PermetreGaz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PermetreGaz|null find($id, $lockMode = null, $lockVersion = null)
 * @method PermetreGaz|null findOneBy(array $criteria, array $orderBy = null)
 * @method PermetreGaz[]    findAll()
 * @method PermetreGaz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PermetreGazRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PermetreGaz::class);
    }

    public function findByPerimGaz($client, $profil)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.client = :client')
            ->andWhere('p.profil = :segmentation')
            ->setParameter('client', $client)
            ->setParameter('segmentation', $profil)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByClient($client)
    {
        return $this->createQueryBuilder('p')
            ->where('p.client = :client')
            ->setParameter('client', $client)
            ->getQuery()
            ->getOneOrNullResult();
    }
    // /**
    //  * @return PermetreGaz[] Returns an array of PermetreGaz objects
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
    public function findOneBySomeField($value): ?PermetreGaz
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
