<?php

namespace App\Repository;

use App\Entity\GerechtType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GerechtType|null find($id, $lockMode = null, $lockVersion = null)
 * @method GerechtType|null findOneBy(array $criteria, array $orderBy = null)
 * @method GerechtType[]    findAll()
 * @method GerechtType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GerechtTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GerechtType::class);
    }

    // /**
    //  * @return GerechtType[] Returns an array of GerechtType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GerechtType
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
