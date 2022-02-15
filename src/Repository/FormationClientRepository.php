<?php

namespace App\Repository;

use App\Entity\FormationClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormationClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationClient[]    findAll()
 * @method FormationClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationClient::class);
    }

    // /**
    //  * @return FormationClient[] Returns an array of FormationClient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormationClient
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
