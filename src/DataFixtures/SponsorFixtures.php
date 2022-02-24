<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Sponsor;
use Faker\Factory as Faker;

class SponsorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $sponsor = new Sponsor();
            $sponsor
                ->setOpponent($faker->city())
                ->setScoreTeam($faker->numberBetween(0, 10))
                ->setScoreOpponent($faker->numberBetween(0, 10))
                ->setGameDate($faker->dateTimeThisMonth("+ $randDay days"))
                ->setHome($faker->boolean())
                ->setTeam($teamId);
            ;
            $manager->persist($sponsor);
        }
    }
}