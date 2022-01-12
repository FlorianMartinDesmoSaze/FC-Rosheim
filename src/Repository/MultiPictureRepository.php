<?php

namespace App\Repository;

use App\Entity\MultiPicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MultiPicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method MultiPicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method MultiPicture[]    findAll()
 * @method MultiPicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MultiPictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MultiPicture::class);
    }

    // /**
    //  * @return MultiPicture[] Returns an array of MultiPicture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MultiPicture
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
