<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture implements FixtureGroupInterface
{
    private array $courses = [
        [1, 'IT Fundamentals', 3, 'GL', 2],
        [2, 'Networking Basics', 7, 'RT', 3],
        [3, 'Introduction to Physics', 10, 'IIA', 4],
        [4, 'Advanced Physics', 12, 'IIA', 3],
        [5, 'Database Management', 5, 'IMI', 4],
        [6, 'Software Development', 14, 'IMI', 5],
        [7, 'Chemistry Fundamentals', 8, 'CH', 3],
        [8, 'Biochemistry', 9, 'BIO', 1],
        [9, 'Microbiology', 13, 'BIO', 1],
        [10, 'Organic Chemistry', 11, 'CH', 4],
        [11, 'Advanced IT', 3, 'GL', 3],
        [12, 'Web Development', 7, 'RT', 4],
        [13, 'Advanced Mathematics', 5, 'MPI', 2],
        [14, 'Statistics', 5, 'MPI', 3],
        [15, 'Bioinformatics', 9, 'CBA', 2],
        [16, 'Genetics', 9, 'CBA', 3],
        [17,'Python', 4, 'GL', 2],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->courses as $course) {
            $courseObj = new \App\Entity\Course();
            $courseObj->setId($course[0]);
            $courseObj->setCoursename($course[1]);
            // Fetch the Teacher entity using the ID
            $teacher = $manager->find(\App\Entity\Teacher::class, $course[2]);
            if ($teacher !== null) {
                $courseObj->setTeacher($teacher);
            }
            $courseObj->setField($course[3]);
            $courseObj->setStudylevel($course[4]);
            $manager->persist($courseObj);
        }

        $manager->flush();
    }

    public function getCourses(): array
    {
        return $this->courses;
    }

    public static function getGroups(): array
    {
        return ['group2'];
    }
}
