<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use App\Entity\Game;
use App\Entity\Team;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $randDay = rand(1,30);
            $randTeam = rand(1, 10);

            $team = new Team();
            $teamId = $team->getId();
            $game = new Game();
            $game
                ->setOpponent($faker->city())
                ->setScoreTeam($faker->numberBetween(0, 10))
                ->setScoreOpponent($faker->numberBetween(0, 10))
                ->setGameDate($faker->dateTimeThisMonth("+ $randDay days"))
                ->setHome($faker->boolean())
                ->setTeam($teamId);
                ;
            $manager->persist($game);
        }

        $manager->flush();
    }
}
