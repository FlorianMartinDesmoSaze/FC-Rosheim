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
                ->setName($faker->company())
                ->setLink($faker->url())
                ->setPicture('//via.placeholder.com/350x150')
                ->setSlug($faker->slug(3, false))
                ->setStatus($faker->boolean())
            ;
            $manager->persist($sponsor);
        }
        $manager->flush();
    }
}