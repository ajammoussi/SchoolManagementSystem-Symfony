<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function findCoursesByTeacherId(int $teacherId)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->where('c.teacher = :teacherId')
            ->setParameter('teacherId', $teacherId);

        return $qb->getQuery()->getResult();
    }

    //teachersPerCourse:
    public function teachersStatistics(): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c.coursename,count(c.teacher) AS nbTeachers')
            ->groupBy('c.coursename');
        return $qb->getQuery()->getResult();

    }
//    /**
//     * @return Course[] Returns an array of Course objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Course
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
