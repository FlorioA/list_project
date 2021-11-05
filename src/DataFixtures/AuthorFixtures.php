<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class AuthorFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < rand(6, 15); $i++) {
            shuffle($users);
            $user = $users[0];

            $author = (new Author())
                ->setName($faker->lastName . ' ' . $faker->firstName())
                ->setUser($user)
                ->setValidated(new DateTime());

            $manager->persist($author);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
