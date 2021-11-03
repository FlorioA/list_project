<?php

namespace App\DataFixtures;

use App\Entity\Author;
use DateTime;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class AuthorFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < rand(6, 15); $i++) {
            $author = (new Author())
                ->setName($faker->lastName . ' ' . $faker->firstName())
                ->setValidated(new DateTime());

            $manager->persist($author);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
