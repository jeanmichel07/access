<?php

namespace App\Repository;

use App\Entity\InfoSuplementaireElec;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InfoSuplementaireElec|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoSuplementaireElec|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoSuplementaireElec[]    findAll()
 * @method InfoSuplementaireElec[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoSuplementaireElecRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoSuplementaireElec::class);
    }
    public function findByOffreElec($offre)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.offreElec = :val')
            ->setParameter('val', $offre)
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return InfoSuplementaireElec[] Returns an array of InfoSuplementaireElec objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InfoSuplementaireElec
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
