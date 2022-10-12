<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\News;
use Faker\Factory as Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class NewsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker::create('fr_FR');

        // $product = new Product();
        // $manager->persist($product);

        for ($i=0; $i < 10; $i++) { 
            $news = new News();
            $news
                ->setTitle($faker->sentence())
                ->setContent($faker->paragraph())
                ->setSlug($faker->slug())
                ->setCreatedAt($faker->dateTime())
                ;

        $manager->persist($news);
        }
        $manager->flush();
    }
}
