<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $user->setUsername($faker->userName());

            $abo = new Subscription();
            $abo->setDuration($faker->randomDigit());
            $abo->setName($faker->userName());
            $abo->setPrice($faker->randomDigitNotNull());

            $user->setCurrentSubscription($abo);

            $manager->persist($user);
            $manager->persist($abo);
        }

        for ($j = 0; $j < 5; $j++) {
            $movie = new Movie();
            $movie->setShortDescription($faker->text());
            $movie->setReleaseDate($faker->dateTime());
            $movie->setTitle($faker->title());
            $movie->setCover($faker->image());
            $movie->setLongDescription($faker->text());
            $movie->setCasting([
                $faker->name(),
                $faker->name(),
                $faker->name(),
            ]);
            $movie->stStaff([
                $faker->name(),
                $faker->name(),
                $faker->name(),
            ]);
        }

        $manager->flush();
    }
}
