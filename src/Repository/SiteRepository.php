<?php

namespace App\Repository;

use App\Entity\Site;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Site>
 *
 * @method Site|null find($id, $lockMode = null, $lockVersion = null)
 * @method Site|null findOneBy(array $criteria, array $orderBy = null)
 * @method Site[]    findAll()
 * @method Site[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Site::class);
    }

    public function findAllSites() {
        $q = $this->createQueryBuilder('s')
            ->orderBy('s.nom', 'ASC')
            ->getQuery();

        return $q->getResult();
    }

    public function findSitesThatcontains($value): array {
        $result = $this->createQueryBuilder('v')
        ->where('v.nom LIKE :value')
        ->setParameter('value' , '%'.$value.'%')
        ->getQuery()
        ->getResult();
    
        return $result;
    }
}
