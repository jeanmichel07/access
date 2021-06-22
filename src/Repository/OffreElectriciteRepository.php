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
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAlls($client)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.client = :client')
            ->setParameter('client', $client)
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySegmentation($segmentation, $client)
    {
        return $this->createQueryBuilder('o')
            ->where('o.segmentation = :segmentation')
            ->andWhere('o.client = :client')
            ->andWhere('o.status = :status')
            ->setParameter('segmentation', $segmentation)
            ->setParameter('client', $client)
            ->setParameter('status', 'En attent')
            ->getQuery()
            ->getResult()
            ;
    }
}
