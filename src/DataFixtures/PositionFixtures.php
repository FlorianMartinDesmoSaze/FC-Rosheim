<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Position;
use Faker\Factory as Faker;


class PositionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $arrayPosition = [
            1 => 'goalKeepers',
            2 => 'defenders',
            3 => 'midfielders',
            4 => 'strickers',
        ];

        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $position = new Position();
            $position
                ->setName($arrayPosition[rand(1, 4)])
                // ->setPosition($arrayPosition[rand(1, 4)])
                ;
            $manager->persist($position);
        }
        $manager->flush();
    }
}
