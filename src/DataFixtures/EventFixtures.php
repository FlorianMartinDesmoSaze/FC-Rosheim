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
            $event = new Event();
            $event
                ->setTitle($faker->sentence())
                ->setDescription($faker->paragraph(2))
                ->setType('sportif')
                ->setStartDate($faker->dateTime())
                ->setEndDate($faker->dateTimeBetween('+1 day', '+1 week'))
                ->setLocation($faker->city())
                ;
            $manager->persist($event);
        }
        $manager->flush();
    }
}
