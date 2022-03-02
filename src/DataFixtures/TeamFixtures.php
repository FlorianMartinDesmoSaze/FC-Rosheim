<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class TeamFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        // $users = $this->userRepository->findAll();
        // $userId = $user->getId();
        
        
        for ($i = 0; $i < 10; $i++) {
            // $values []= $faker->unique()->randomDigitNotNull();
            // $user = $faker->unique()->randomDigit($values);
            // $manager->persist($user);

            $team = new Team();
            $team
                ->setTeamName("FC" . $faker->lastName())
                ->setSeason("spring")
                ->setPicture("/player-test-621e2a5c519b2.png")
                ->setSlug($faker->slug(3, false))
                ;
            $manager->persist($team);
        }

        $manager->flush();
    }
}
