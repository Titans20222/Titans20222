<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Data\SearchDataRec1;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    /**
      * @return Evenement[] Returns an array of Evenement objects
      *
    */
/*    public function findBynom($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nomEvenement = :val')
            ->setParameter('val', $value)
            ->orderBy('e.nomEvenement', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

/**
 * recupere les annonces en lien avec recherche
 * @return Evenement[]
 */
public function findSearch(SearchDataRec1 $search):array
{
    $query= $this
        ->createQueryBuilder('x');


    if (!empty($search->y))
    {
        $query=$query
            ->andWhere('x.nomEvenement LIKE :y ')
            ->setParameter('y',"{$search->y}%");
    }

    return $query->getQuery()->getResult();
}


    /*
    public function findOneBySomeField($value): ?Evenement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
