<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{
    private array $admins = [
        [1, 'adminuser', 'admin@example.com', 'admin123']
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->admins as $admin) {
            $adminObj = new \App\Entity\Admin();
            $adminObj->setId($admin[0]);
            $adminObj->setUsername($admin[1]);
            $adminObj->setEmail($admin[2]);
            $adminObj->setPassword($admin[3]);
            $manager->persist($adminObj);
        }

        $manager->flush();
    }
}
