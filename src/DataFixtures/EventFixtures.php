<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;
use DateTime;
use Faker\Factory as Faker;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        
        for ($i = 0; $i < 10; $i++) {
            $randDay = rand(1, 30);
            $randDayTwo = $randDay+1;
            $randDayThree = $randDayTwo+1;

            $event = new Event();
            $event
                ->setTitle($faker->sentence())
                ->setDescription($faker->paragraph(2))
                ->setType('sportif')
                ->setStartDate($faker->dateTimeBetween('+'.$randDay.' day', '+'.$randDayTwo.' day'))
                ->setEndDate($faker->dateTimeBetween('+'.$randDayTwo.' day', '+'.$randDayThree.' day'))
                ->setLocation($faker->city())
                ;
            $manager->persist($event);
        }
        $manager->flush();
    }
}
