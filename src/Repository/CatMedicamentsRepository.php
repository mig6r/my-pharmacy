<?php

namespace App\Repository;

use App\Entity\CatMedicaments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CatMedicaments|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatMedicaments|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatMedicaments[]    findAll()
 * @method CatMedicaments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatMedicamentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CatMedicaments::class);
    }

    /**
     * @param $famille
     * @return mixed
     */
    public function findAllForUser($famille)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.famille = :val')
            ->setParameter('val', $famille)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


    // /**
    //  * @return CatMedicaments[] Returns an array of CatMedicaments objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CatMedicaments
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
