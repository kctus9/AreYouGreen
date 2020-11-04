<?php

namespace App\Repository;

use App\Entity\ThematiqueQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ThematiqueQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThematiqueQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThematiqueQuestion[]    findAll()
 * @method ThematiqueQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThematiqueQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThematiqueQuestion::class);
    }

    // /**
    //  * @return ThematiqueQuestion[] Returns an array of ThematiqueQuestion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ThematiqueQuestion
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
