<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Player;
use Faker\Factory as Faker;

class PlayerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        $arrayPosition = [
            1 => 'goalKeepers',
            2 => 'defenders',
            3 => 'midfielders',
            4 => 'strickers',
        ];

        for ($i = 0; $i < 10; $i++) {
            $player = new Player();
            $player
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setNumber($faker->numberBetween(1, 30))
                ->setBirthdate($faker->dateTimeBetween('-40 year', '-18 year'))
                ->setPicture('player-test.png')
                ->setSlug($faker->slug(3, false))
                ->setTeam(null)
                ->setPosition(null)
                ;
            $manager->persist($player);
        }

        $manager->flush();
    }
}
