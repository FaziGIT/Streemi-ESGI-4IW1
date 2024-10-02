<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Media;
use App\Entity\Movie;
use App\Entity\Playlist;
use App\Entity\PlaylistMedia;
use App\Entity\PlaylistSubscription;
use App\Entity\Season;
use App\Entity\Serie;
use App\Entity\Subscription;
use App\Entity\User;
use App\Enum\UserAccountStatusEnum;
use App\Enum\CommentStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email())
                ->setPassword($faker->password())
                ->setUsername($faker->userName())
                ->setAccountStatus($faker->randomElement(UserAccountStatusEnum::cases()));

            $abo = new Subscription();
            $abo->setDuration($faker->randomDigit())
                ->setName($faker->word())
                ->setPrice($faker->randomFloat(2, 5, 50));
            $user->setCurrentSubscription($abo);

            $manager->persist($user);
            $manager->persist($abo);

            $users[] = $user;
        }

        $manager->flush();

        for ($i = 0; $i < 5; $i++) {
            $serie = new Serie();
            $serie->setTitle($faker->sentence())
                ->setShortDescription($faker->text())
                ->setLongDescription($faker->paragraph())
                ->setReleaseDate($faker->dateTime())
                ->setCover($faker->imageUrl());

            $manager->persist($serie);

            for ($j = 0; $j < $faker->numberBetween(1, 5); $j++) {
                $season = new Season();
                $season->setSeasonNumber($j + 1)
                    ->setSerie($serie);

                $manager->persist($season);

                for ($k = 0; $k < $faker->numberBetween(3, 10); $k++) {
                    $episode = new Episode();
                    $episode->setTitle("Épisode " . ($k + 1))
                        ->setDuration(new \DateTime())
                        ->setReleaseDate($faker->dateTime())
                        ->setSeason($season);

                    $manager->persist($episode);
                }
            }

            $this->createComments($serie, $manager, $faker, $users);
        }

        for ($i = 0; $i < 3; $i++) {
            $movie = new Movie();
            $movie->setTitle($faker->sentence())
                ->setShortDescription($faker->text())
                ->setLongDescription($faker->paragraph())
                ->setReleaseDate($faker->dateTime())
                ->setCover($faker->imageUrl());

            $manager->persist($movie);

            $this->createComments($movie, $manager, $faker, $users);
        }

        // Ajout des fixtures pour Playlist, PlaylistSubscription, et PlaylistMedia
        for ($i = 0; $i < 5; $i++) {
            $playlist = new Playlist();
            $playlist->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setName($faker->sentence())
                ->setUser($faker->randomElement($users));

            $manager->persist($playlist);

            for ($j = 0; $j < $faker->numberBetween(1, 3); $j++) {
                $playlistSubscription = new PlaylistSubscription();
                $playlistSubscription->setSubscribedAt(new \DateTimeImmutable())
                    ->setPurchased($faker->randomElement($users))
                    ->setPlaylist($playlist);

                $manager->persist($playlistSubscription);
            }

            for ($k = 0; $k < $faker->numberBetween(1, 5); $k++) {
                $playlistMedia = new PlaylistMedia();
                $playlistMedia->setPlaylist($playlist)
                    ->setMedia($faker->randomElement([$serie, $movie]))
                    ->setAddedAt(new \DateTimeImmutable()); // Assurez-vous d'initialiser addedAt ici

                $manager->persist($playlistMedia);
            }
        }

        $manager->flush();
    }

    private function createComments($media, ObjectManager $manager, $faker, $users): void
    {
        for ($j = 0; $j < $faker->numberBetween(2, 5); $j++) {
            $comment = new Comment();
            $comment->setTexte($faker->paragraph())
                ->setStatus($faker->randomElement(CommentStatusEnum::cases()))
                ->setMedia($media)
                ->setPublisher($faker->randomElement($users)); // Assurez-vous de définir le publisher ici

            $manager->persist($comment);

            for ($k = 0; $k < $faker->numberBetween(0, 3); $k++) {
                $childComment = new Comment();
                $childComment->setTexte($faker->paragraph())
                    ->setStatus($faker->randomElement(CommentStatusEnum::cases()))
                    ->setParentComment($comment)
                    ->setMedia($media)
                    ->setPublisher($faker->randomElement($users)); // Assurez-vous de définir le publisher ici

                $manager->persist($childComment);
            }
        }
    }
}
