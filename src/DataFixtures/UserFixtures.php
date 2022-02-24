<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory as Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * hash password
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;    
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setRoles(["ROLE_USER"])
                ->setPassword($this->encoder->encodePassword($user, '123Password!'))
                ->setNickname($faker->userName())
                ->setPhone($faker->phoneNumber())
                ->setLastName($faker->lastName())
                ->setFirstName($faker->firstName())
                ->setBirthdate($faker->dateTimeBetween('-90 year', '-10 year'))
                ->setLicense($faker->numberBetween(0, 1))
                ->setTeam(null)
                ;
            $manager->persist($user);
        }

        $manager->flush();
    }
}
