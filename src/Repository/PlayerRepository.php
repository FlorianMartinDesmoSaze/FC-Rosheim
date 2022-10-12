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
    public function findPlayersByPosition($id, $idPosition)
    {
        return $this->createQueryBuilder('p')
            ->where('p.team = :id')
            ->setParameter('id', $id)
            ->andWhere('p.position = :idPosition') 
            ->setParameter('idPosition', $idPosition)
            ->getQuery()
            ->getResult()
        ;
    }
}
