<?php

namespace App\Repository;

use App\Entity\LigneDeCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LigneDeCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneDeCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneDeCommande[]    findAll()
 * @method LigneDeCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneDeCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneDeCommande::class);
    }

    // /**
    //  * @return LigneDeCommande[] Returns an array of LigneDeCommande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LigneDeCommande
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    function SearchByEmp($nsc)

    {
        return $this->createQueryBuilder('o')
            ->where ('o.lignedecommande = :lignedecommande')
            ->setParameter('lignedecommande',$nsc)
            ->getQuery()->getResult();
        ;

    }
    function SearchNom($nsc)

    {
        return $this->createQueryBuilder('o')
            ->where ('o.ligne LIKE :ligne')
            ->setParameter('ligne','%'.$nsc.'%')
            ->getQuery()->getResult();
        ;

    }

    public function findEntitiesByString($str)
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\LigneDeCommande p
            WHERE p.ligne LIKE :str'

        )->setParameter('str', $str);

        // returns an array of Product objects
        return $query->getResult();
    }

}
