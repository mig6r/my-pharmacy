<?php

namespace App\Repository;

use App\Entity\Symptome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Symptome|null find($id, $lockMode = null, $lockVersion = null)
 * @method Symptome|null findOneBy(array $criteria, array $orderBy = null)
 * @method Symptome[]    findAll()
 * @method Symptome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SymptomeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Symptome::class);
    }

    // /**
    //  * @return Symptome[] Returns an array of Symptome objects
    //  */

    public function findAllForUser($famille)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.famille = :val')
            ->setParameter('val', $famille)
            ->orderBy('s.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Symptome
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
