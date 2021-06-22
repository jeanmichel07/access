<?php

namespace App\Repository;

use App\Entity\OffreGaz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OffreGaz|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreGaz|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreGaz[]    findAll()
 * @method OffreGaz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreGazRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreGaz::class);
    }

    public function findFive($client){
        return $this->createQueryBuilder('o')
            ->andWhere('o.client = :client')
            ->setParameter('client', $client)
            ->orderBy('o.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
            ;
    }
    public function findAlls($client){
        return $this->createQueryBuilder('o')
            ->andWhere('o.client = :client')
            ->setParameter('client', $client)
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findByProfil($profil, $client)
    {
        return $this->createQueryBuilder('o')
            ->where('o.profil = :profil')
            ->andWhere('o.client = :client')
            ->andWhere('o.status = :status')
            ->setParameter('profil', $profil)
            ->setParameter('client', $client)
            ->setParameter('status', 'En attent')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return OffreGaz[] Returns an array of OffreGaz objects
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
    public function findOneBySomeField($value): ?OffreGaz
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
