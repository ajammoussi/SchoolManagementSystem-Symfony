<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture implements FixtureGroupInterface
{
    private array $admins = [
        [1, 'adminuser', 'admin@example.com', 'admin123']
    ];
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->admins as $admin) {
            $adminObj = new \App\Entity\Admin();
            $adminObj->setId($admin[0]);
            $adminObj->setUsername($admin[1]);
            $adminObj->setEmail($admin[2]);
            //hash the password with the same algorithm symfony uses to compare
            $hashedPassword = $this->passwordHasher->hashPassword($adminObj, $admin[3]);
            $adminObj->setPassword($hashedPassword);$manager->persist($adminObj);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}
