<?php

namespace App\Repository;

use App\Entity\Deliverrando;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Deliverrando|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deliverrando|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deliverrando[]    findAll()
 * @method Deliverrando[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliverrandoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deliverrando::class);
    }

    // /**
    //  * @return Deliverrando[] Returns an array of Deliverrando objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Deliverrando
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
