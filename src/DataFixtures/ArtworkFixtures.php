<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Media;
use App\Entity\Author;
use App\Entity\Artwork;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ArtworkFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $authors = $manager->getRepository(Author::class)->findAll();
        $medias = $manager->getRepository(Media::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < rand(15, 30); $i++) {
            shuffle($authors);
            $author = $authors[0];
            shuffle($medias);
            $media = $medias[0];
            shuffle($users);
            $user = $users[0];

            $artwork = (new Artwork())
                ->setTitle($faker->words(rand(1, 4), true))
                ->setDescription($faker->paragraph(rand(2, 5)))
                ->setValidated(new DateTime())
                ->setMedia($media)
                ->addAuthor($author)
                ->setUser($user)
                ->setImage('placeholder.jpg');

            $manager->persist($artwork);
            $manager->persist($author);
            $manager->persist($media);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
