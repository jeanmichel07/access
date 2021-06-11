<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }
    public function findClient()
    {
        $dql = $this->getEntityManager();

        $query = $dql->createQuery('Select c from App\Entity\Client c where c.id not IN (select cl.id from App\Entity\Client cl INNER JOIN App\Entity\OffreElectricite o with cl.id = o.client)');
        return $query->getResult()
            ;
    }
    public function findClientNotGaz()
    {
        $dql = $this->getEntityManager();

        $query = $dql->createQuery('Select c from App\Entity\Client c where c.id not IN (select cl.id from App\Entity\Client cl INNER JOIN App\Entity\OffreGaz o with cl.id = o.client)');
        return $query->getResult()
            ;
    }

    public function findAllClient(){
        $dql = $this->getEntityManager();
        $query = $dql->createQuery('select c from App\Entity\Client c left join App\Entity\PerimetreElectricite p with c.id = p.client');

        return $query->getResult();
    }

    public function getClientByFilter($segmant, $vendeur, $state, $client){
        $dql = $this->getEntityManager();
        if($segmant == "" and $vendeur == "" and $state == "" and $client == ""){
            $query = $dql->createQuery('select c from App\Entity\Client c left join App\Entity\PerimetreElectricite p with c.id = p.client order by c.id desc');
        }elseif($vendeur == ""){
            $query = $dql->createQuery('select c from App\Entity\Client c left join App\Entity\PerimetreElectricite p with c.id = p.client inner join App\Entity\Segmentation s with p.segmentation = s.id where s.nom like :seg and c.statut like :state and (c.nomSignataire like :cline or c.prenomSignataire like :cline) order by c.id desc')
            ->setParameter('seg', '%'.$segmant.'%')
            ->setParameter('state', '%'.$state.'%')
            ->setParameter('cline', '%'.$client.'%');
        }else{
            $query = $dql->createQuery('select c from App\Entity\Client c left join App\Entity\PerimetreElectricite p with c.id = p.client inner join App\Entity\Segmentation s with p.segmentation = s.id inner join App\Entity\Vendeur v with c.vendeur = v.id where s.nom like :seg and c.statut like :state and c.nomSignataire like :cline and v.nom like :vendeur order by c.id desc')
                ->setParameter('seg', '%'.$segmant.'%')
                ->setParameter('state', '%'.$state.'%')
                ->setParameter('cline', '%'.$client.'%')
                ->setParameter('vendeur', '%'.$vendeur.'%');
        }
        return $query->getResult();
    }
}
