<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use App\Entity\Staff;
use App\Entity\User;

class StaffFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $user = new User();
        // $userId = $user->getId;
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $staff = new Staff();
            $staff
                ->setLastName($faker->lastName())
                ->setFirstName($faker->firstName())
                ->setPosition($faker->jobTitle())
                ->setPhone($faker->phoneNumber())
                ->setEmail($faker->email())
                // ->setUser($userId)
                ->setPicture('//via.placeholder.com/350x150')
                ;
            $manager->persist($staff);
        }
        $manager->flush();
    }
}
