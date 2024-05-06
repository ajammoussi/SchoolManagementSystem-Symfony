<?php

namespace App\DataFixtures;

use Cassandra\Date;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AbsenceFixtures extends Fixture implements FixtureGroupInterface
{
    private array $absences = [
        [1,1,1,'2024-01-10'],
        [2,1,1,'2024-01-15'],
        [3,1,1,'2024-02-15'],
        [4,1,1,'2024-03-22'],
        [5,1,1,'2024-04-01'],
        [6,2,2,'2024-01-15'],
        [7,2,2,'2024-02-20'],
        [8,2,2,'2024-04-03'],
        [9,4,5,'2024-01-20'],
        [10,4,5,'2024-04-09'],
        [11,13,7,'2024-04-05'],
        [12,33,1,'2024-02-10'],
        [13,36,6,'2024-04-09'],
        [14,39,1,'2024-04-10'],
        [15,39,17,'2024-04-10'],
        [16,39,17,'2024-04-11'],
        [17,39,17,'2024-04-12'],
    ];



    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        try {
            foreach ($this->absences as $absence) {
                $absenceObj = new \App\Entity\Absence();
                $absenceObj->setId($absence[0]);
                // Fetch the Student entity using the ID
                $student = $manager->find(\App\Entity\Student::class, $absence[1]);
                if ($student !== null) {
                    $absenceObj->setStudent($student);
                }
                // Fetch the Course entity using the ID
                $course = $manager->find(\App\Entity\Course::class, $absence[2]);
                if ($course !== null) {
                    $absenceObj->setCourse($course);
                }
                $absenceDate = new \DateTime($absence[3]);
                $absenceObj->setAbsenceDate($absenceDate);
                $manager->persist($absenceObj);
            }

            $manager->flush();
        } catch (\Exception $e) {
            // Output the exception message to the console
            echo $e->getMessage();
        }

    }

    public static function getGroups(): array
    {
        return ['group3'];
    }
}
