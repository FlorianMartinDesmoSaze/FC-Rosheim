<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function passedGames($today)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.gameDate < :today')
            ->setParameter('today', $today)
            ->orderBy('g.gameDate', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    public function upcomingGames($today)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.gameDate > :today')
            ->setParameter('today', $today)
            ->orderBy('g.gameDate', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findAllByLatest()
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.gameDate', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
