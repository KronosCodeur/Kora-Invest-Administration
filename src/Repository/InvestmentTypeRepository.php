<?php

namespace App\Repository;

use App\Entity\InvestmentType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InvestmentType>
 *
 * @method InvestmentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvestmentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvestmentType[]    findAll()
 * @method InvestmentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvestmentTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvestmentType::class);
    }

//    /**
//     * @return InvestmentType[] Returns an array of InvestmentType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InvestmentType
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
