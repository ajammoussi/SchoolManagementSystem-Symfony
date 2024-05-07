<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CourseVideoFixtures extends Fixture implements FixtureGroupInterface
{
    private array $courseVideos=[
        [1,'https://www.youtube.com/watch?v=-uleG_Vecis','Computer Science Concepts Explained','Learn the fundamentals of Computer Science with a quick breakdown of jargon that every software engineer should know. Over 100 technical concepts from the CS curriculum are explained to provide a foundation for programmers.','GL',2],
        [2,'https://www.youtube.com/watch?v=oHQvWa6J8dU','Introduction to Networking Basics','This video introduces the basics of Networking','RT',3],
        [3,'https://www.youtube.com/watch?v=JwSS70SZdyM','Introduction to Python','This video introduces the basics of Python','RT',4],
        [4,'https://www.youtube.com/watch?v=oHQvWa6J8dU','Introduction to Networking Basics','This video introduces the basics of Networking','GL',2],
        [5,'https://www.youtube.com/watch?v=JwSS70SZdyM','Introduction to Python','This video introduces the basics of Python','GL',2],
        [6, 'https://www.youtube.com/watch?v=abc123', 'Physics Fundamentals', 'Explore the basic principles of physics, covering topics such as mechanics, thermodynamics, and electromagnetism.', 'IMI', 3],
        [7, 'https://www.youtube.com/watch?v=def456', 'Introduction to Electronics', 'Learn about electronic components, circuits, and devices.', 'IIA', 3],
        [8, 'https://www.youtube.com/watch?v=ghi789', 'Biology Basics', 'Discover the basics of biology, including cells, genetics, and ecology.', 'BIO', 4],
        [9, 'https://www.youtube.com/watch?v=jkl012', 'Chemistry Essentials', 'An essential overview of key concepts in chemistry.', 'CH', 4],
        [10, 'https://www.youtube.com/watch?v=mno345', 'Introduction to Statistics', 'Learn the basics of statistics, including data analysis and probability.', 'MPI', 1],
        [11, 'https://www.youtube.com/watch?v=pqr678', 'Software Development Principles', 'Explore the principles of software development, including design patterns and best practices.', 'GL', 3],
        [12, 'https://www.youtube.com/watch?v=stu901', 'Web Development Basics', 'Learn the basics of web development, including HTML, CSS, and JavaScript.', 'GL', 2],
        [13, 'https://www.youtube.com/watch?v=vwx234', 'Introduction to Databases', 'Discover the fundamentals of database management, including SQL and data modeling.', 'RT', 2],
        [14, 'https://www.youtube.com/watch?v=yzab56', 'Introduction to Bioinformatics', 'Learn about bioinformatics, including genomics, proteomics, and computational biology.', 'BIO', 2],
        [15, 'https://www.youtube.com/watch?v=def456', 'Introduction to Electronics', 'Learn about electronic components, circuits, and devices.', 'IMI', 2],
        [16, 'https://www.youtube.com/watch?v=ghi789', 'Biology Basics', 'Discover the basics of biology, including cells, genetics, and ecology.', 'CH', 4],
        [17, 'https://www.youtube.com/watch?v=jkl012', 'Chemistry Essentials', 'An essential overview of key concepts in chemistry.', 'CH', 4],
        [18, 'https://www.youtube.com/watch?v=mno345', 'Introduction to Statistics', 'Learn the basics of statistics, including data analysis and probability.', 'MPI', 1],
        [19, 'https://www.youtube.com/watch?v=pqr678', 'Software Development Principles', 'Explore the principles of software development, including design patterns and best practices.', 'RT', 3],
        [20, 'https://www.youtube.com/watch?v=stu901', 'Web Development Basics', 'Learn the basics of web development, including HTML, CSS, and JavaScript.', 'MPI', 1],
        [21, 'https://www.youtube.com/watch?v=vwx234', 'Introduction to Databases', 'Discover the fundamentals of database management, including SQL and data modeling.', 'GL', 2],
        [22, 'https://www.youtube.com/watch?v=123xyz', 'Algebra Basics', 'Introduction to fundamental algebra concepts and operations.', 'MPI', 1],
        [23, 'https://www.youtube.com/watch?v=456abc', 'Geometry Fundamentals', 'Explore basic geometry principles and shapes.', 'MPI', 1],
        [24, 'https://www.youtube.com/watch?v=789def', 'Introduction to Biology', 'An overview of basic biology concepts and life sciences.', 'CBA', 1],
        [25, 'https://www.youtube.com/watch?v=xyz123', 'Chemistry Essentials', 'Foundational concepts in chemistry, including atoms, molecules, and chemical reactions.', 'CBA', 1]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->courseVideos as $courseVideo) {
            $courseVideoObj = new \App\Entity\CourseVideo();
            $courseVideoObj->setId($courseVideo[0]);
            $courseVideoObj->setUrl($courseVideo[1]);
            $courseVideoObj->setTitle($courseVideo[2]);
            $courseVideoObj->setDescription($courseVideo[3]);
            $courseVideoObj->setField($courseVideo[4]);
            $courseVideoObj->setStudylevel($courseVideo[5]);
            $manager->persist($courseVideoObj);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }
}
