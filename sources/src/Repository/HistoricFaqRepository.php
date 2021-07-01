<?php

namespace App\Repository;

use App\Entity\HistoricFaq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HistoricFaq|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoricFaq|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoricFaq[]    findAll()
 * @method HistoricFaq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoricFaqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoricFaq::class);
    }

    // /**
    //  * @return HistoricFaq[] Returns an array of HistoricFaq objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HistoricFaq
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
