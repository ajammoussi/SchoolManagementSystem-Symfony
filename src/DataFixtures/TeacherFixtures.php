<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture implements FixtureGroupInterface
{
    private array $teachers = [
        [1, 'Hichem', 'Ben Ali', 'hichem.benali@example.com', 'pass123', 23456789, 'Male'],
        [2, 'Noura', 'Chaabane', 'noura.chaabane@example.com', 'pass456', 34567890, 'Female'],
        [3, 'Khaled', 'Dhahri', 'khaled.dhahri@example.com', 'pass789', 45678901, 'Male'],
        [4, 'Amira', 'Guesmi', 'amira.guesmi@example.com', 'passabc', 56789012, 'Female'],
        [5, 'Mohamed', 'Khelifi', 'mohamed.khelifi@example.com', 'passdef', 67890123, 'Male'],
        [6, 'Ines', 'Mabrouk', 'ines.mabrouk@example.com', 'pass123', 78901234, 'Female'],
        [7, 'Sami', 'Nasri', 'sami.nasri@example.com', 'pass456', 89012345, 'Male'],
        [8, 'Yosra', 'Ouni', 'yosra.ouni@example.com', 'pass789', 90123456, 'Female'],
        [9, 'Adel', 'Rahmani', 'adel.rahmani@example.com', 'passabc', 12345678, 'Male'],
        [10, 'Lina', 'Saidi', 'lina.saidi@example.com', 'pass123', 23456789, 'Female'],
        [11, 'Ahmed', 'Trabelsi', 'ahmed.trabelsi@example.com', 'pass456', 34567890, 'Male'],
        [12, 'Amina', 'Zouari', 'amina.zouari@example.com', 'pass789', 45678901, 'Female'],
        [13, 'Raouf', 'Ammar', 'raouf.ammar@example.com', 'passabc', 56789012, 'Male'],
        [14, 'Fatma', 'Brahmi', 'fatma.brahmi@example.com', 'pass123', 67890123, 'Female'],
        [15, 'Wassim', 'Chaieb', 'wassim.chaieb@example.com', 'pass456', 78901234, 'Male'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->teachers as $teacher) {
            $teacherObj = new \App\Entity\Teacher();
            $teacherObj->setId($teacher[0]);
            $teacherObj->setFirstName($teacher[1]);
            $teacherObj->setLastName($teacher[2]);
            $teacherObj->setEmail($teacher[3]);
            $teacherObj->setPassword($teacher[4]);
            $teacherObj->setPhone($teacher[5]);
            $teacherObj->setGender($teacher[6]);
            $manager->persist($teacherObj);
        }

        $manager->flush();
    }

    public function getTeachers(): array
    {
        return $this->teachers;
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}
