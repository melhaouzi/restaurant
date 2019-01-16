<?php

namespace App\Repository;

use App\Entity\Openingstijden;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Openingstijden|null find($id, $lockMode = null, $lockVersion = null)
 * @method Openingstijden|null findOneBy(array $criteria, array $orderBy = null)
 * @method Openingstijden[]    findAll()
 * @method Openingstijden[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpeningstijdenRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Openingstijden::class);
    }

    // /**
    //  * @return Openingstijden[] Returns an array of Openingstijden objects
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
    public function findOneBySomeField($value): ?Openingstijden
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
