<?php

namespace App\DataFixtures;

use App\Entity\Artwork;
use App\Entity\Author;
use App\Entity\Media;
use App\Entity\User;
use DateTime;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Date;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private UserPasswordHasherInterface $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $admin = (new User())
            ->setName('Admin')
            ->setEmail('admin@mail.com')
            ->setRoles(['ROLE_ADMIN']);

        $admin->setPassword(
            $this->userPasswordHasherInterface->hashPassword(
                $admin,
                'aaaaaaaa'
            )
        );

        $manager->persist($admin);

        for ($i = 0; $i < rand(5, 10); $i++) {
            $user = (new User())
                ->setName($faker->lastName)
                ->setEmail($faker->email);

            $user->setPassword(
                $this->userPasswordHasherInterface->hashPassword(
                    $user,
                    'aaaaaaaa'
                )
            );

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
