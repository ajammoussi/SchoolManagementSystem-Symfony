<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class ScheduleFixtures extends Fixture implements FixtureGroupInterface
{
    private array $Schedule=[
        [1, 1,  '2024-04-29' , '09:00:00', '11:00:00', 'Room A', 1, 'Introduction to Programming', '2024-04-22 00:00:00', 'GL', 2],
        [2, 2,  '2024-04-29' ,'13:00:00', '15:00:00', 'Room B', 2, 'Database Management', '2024-04-23 00:00:00', 'GL', 2],
        [3, 3,  '2024-04-30' ,'14:00:00', '16:00:00', 'Room C', 3, 'Network Security', '2024-04-24 00:00:00', 'GL', 2],
        [4, 4,  '2024-04-30' ,'09:00:00', '11:00:00', 'Room D', 4, 'Web Development', '2024-04-25 00:00:00', 'GL', 2],
        [5, 5,  '2024-05-01' ,'08:00:00', '10:00:00', 'Room E', 5, 'Computer Architecture', '2024-04-26 00:00:00', 'GL', 2],
        [6, 6,  '2024-05-01' ,'14:00:00', '16:00:00', 'Room F', 6, 'Software Engineering', '2024-04-29 00:00:00', 'GL', 2],
        [7, 7,  '2024-05-02' ,'09:00:00', '11:00:00', 'Room G', 7, 'Operating Systems', '2024-04-30 00:00:00', 'GL', 2],
        [8, 8,  '2024-05-02' ,'13:00:00', '15:00:00', 'Room H', 8, 'Data Structures', '2024-05-01 00:00:00', 'GL', 2],
        [9, 9,  '2024-05-03' ,'10:00:00', '12:00:00', 'Room I', 9, 'Cybersecurity Fundamentals', '2024-05-02 00:00:00', 'GL', 2],
        [10,10,  '2024-05-04' ,'09:00:00', '11:00:00', 'Room J', 10, 'Software Testing', '2024-05-03 00:00:00', 'GL', 2],
        [11,11,  '2024-05-05' ,'11:00:00', '13:00:00', 'Room K', 11, 'Computer Networks', '2024-05-06 00:00:00', 'GL', 2],
        [12,12,  '2024-05-05' ,'14:00:00', '16:00:00', 'Room L', 12, 'Information Security', '2024-05-07 00:00:00', 'GL', 2],
        [13,13,  '2024-05-06' ,'08:00:00', '10:00:00', 'Room M', 13, 'Artificial Intelligence', '2024-05-08 00:00:00', 'GL', 2],
        [14,14,  '2024-05-06' ,'13:00:00', '15:00:00', 'Room N', 14, 'Mobile App Development', '2024-05-09 00:00:00', 'GL', 2],
        [15, 5,  '2024-05-01' ,'10:00:00', '12:00:00', 'Room E', 5, 'Computer Architecture', '2024-04-26 00:00:00', 'GL', 2],
        [16, 5,  '2024-05-01' ,'14:00:00', '16:00:00', 'Room E', 5, 'Computer Architecture', '2024-04-26 00:00:00', 'GL', 3],
        [17,5,  '2024-05-03' ,'08:00:00', '10:00:00', 'Room M', 5, 'Artificial Intelligence', '2024-05-08 00:00:00', 'GL', 2],
        [18,5,  '2024-05-03' ,'10:00:00', '11:30:00', 'Room M', 5, 'Artificial Intelligence', '2024-05-08 00:00:00', 'GL', 1],
        [19,5,  '2024-05-03' ,'14:00:00', '16:00:00', 'Room M', 5, 'Artificial Intelligence', '2024-05-08 00:00:00', 'GL', 3],

    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->Schedule as $schedule) {
            $scheduleObj = new \App\Entity\Schedule();
            $scheduleObj->setScheduleId($schedule[0]);
            // Fetch the Course entity using the ID
            $course = $manager->find(\App\Entity\Course::class, $schedule[1]);
            if ($course !== null) {
                $scheduleObj->setCourse($course);
            }
            $scheduleObj->setStartDate(new \DateTime($schedule[2]));
            $scheduleObj->setStartTime(\DateTime::createFromFormat('H:i:s', $schedule[3]));
            $scheduleObj->setEndTime(\DateTime::createFromFormat('H:i:s', $schedule[4]));
            $scheduleObj->setRoom($schedule[5]);
            // Fetch the Teacher entity using the ID
            $instructor = $manager->find(\App\Entity\Teacher::class, $schedule[6]);
            if ($instructor !== null) {
                $scheduleObj->setInstructor($instructor);
            }
            $scheduleObj->setDescription($schedule[7]);
            $scheduleObj->setExpiryDate(new \DateTime($schedule[8]));
            $scheduleObj->setField($schedule[9]);
            $scheduleObj->setStudylevel($schedule[10]);
            $manager->persist($scheduleObj);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group3'];
    }
}
