<?php

namespace App\Repository;

use App\Entity\BestelRegel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BestelRegel|null find($id, $lockMode = null, $lockVersion = null)
 * @method BestelRegel|null findOneBy(array $criteria, array $orderBy = null)
 * @method BestelRegel[]    findAll()
 * @method BestelRegel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BestelRegelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BestelRegel::class);
    }

    // /**
    //  * @return BestelRegel[] Returns an array of BestelRegel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BestelRegel
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
