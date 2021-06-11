<?php

namespace App\Repository;

use App\Entity\InfoSuplementaireGaz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InfoSuplementaireGaz|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoSuplementaireGaz|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoSuplementaireGaz[]    findAll()
 * @method InfoSuplementaireGaz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoSuplementaireGazRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoSuplementaireGaz::class);
    }
    public function findByOffreGaz($offre)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.OffreGaz = :val')
            ->setParameter('val', $offre)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return InfoSuplementaireGaz[] Returns an array of InfoSuplementaireGaz objects
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
    public function findOneBySomeField($value): ?InfoSuplementaireGaz
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
