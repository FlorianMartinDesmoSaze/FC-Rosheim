<?php

namespace App\DataFixtures;

use App\Entity\Staff;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class StaffFixtures extends Fixture
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        // $users = $this->userRepository->findAll();
        // $userId = $user->getId();
        
        
        for ($i = 0; $i < 10; $i++) {
            // $values []= $faker->unique()->randomDigitNotNull();
            // $user = $faker->unique()->randomDigit($values);
            // $manager->persist($user);

            $staff = new Staff();
            $staff
                ->setLastName($faker->lastName())
                ->setFirstName($faker->firstName())
                ->setPosition($faker->jobTitle())
                ->setPhone($faker->phoneNumber())
                ->setEmail($faker->email())
                // ->setUser($user)
                ;
            $manager->persist($staff);
        }
        $manager->flush();
    }
}
