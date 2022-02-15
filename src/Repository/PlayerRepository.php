<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    //request to find players by team in BDD
    public function findPlayersByTeam($id)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.team = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }
    //request to find Goal keepers by position and team
    public function findGKByPosition($id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.team = :id')
            ->setParameter('id', $id)
            ->andWhere('p.position = 1') //1 = Goalkeeper in bdd
            ->getQuery()
            ->getResult()
        ;
    }
    //request to find defenders by position and team
    public function findDefendersByPosition($id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.team = :id')
            ->setParameter('id', $id)
            ->andWhere('p.position = 2') //2 = Defender in bdd
            ->getQuery()
            ->getResult()
        ;
    }

    //request to find midfielders by position and team
    public function findMidfieldersByPosition($id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.team = :id')
            ->setParameter('id', $id)
            ->andWhere('p.midfielder = 3') //3 = Midfielder in bdd
            ->getQuery()
            ->getResult()
        ;
    }

    //request to find strickers by position and team
    public function findStrickersByPosition($id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.team = :id')
            ->setParameter('id', $id)
            ->andWhere('p.midfielder = 4') //4 = Stricker in bdd
            ->getQuery()
            ->getResult()
        ;
    }
}
