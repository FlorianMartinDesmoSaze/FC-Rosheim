<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use App\Entity\stats;
use App\Entity\Player;
use App\Repository\PlayerRepository;

class StatsFixtures extends Fixture
{
    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {


            $stats = new Stats();
            $stats
                ->setGamePlayed($faker->numberBetween(0, 100))
                ->setCleanSheets($faker->numberBetween(0, 10))
                ->setSaves($faker->numberBetween(0, 1))
                ->setAssists($faker->numberBetween(0, 10))
                ->setGoals($faker->numberBetween(0, 50))
                ->setYellowCards($faker->numberBetween(0, 10))
                ;
            $manager->persist($stats);
        }
        $manager->flush();
    }
}
