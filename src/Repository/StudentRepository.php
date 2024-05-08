<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function findStudentsByTeacherId(int $teacherId)
    {
        $qb = $this->createQueryBuilder('s');

        $qb->select('s', 'CONCAT(\'(\', c.id, \') \',c.coursename) AS enrolledcourse')
            ->innerJoin(Course::class, 'c', 'WITH', 's.field = c.field AND s.studylevel = c.studylevel')
            ->innerJoin(Teacher::class, 't', 'WITH', 'c.teacher = t.id')
            ->where('c.teacher = :teacherId')
            ->setParameter('teacherId', $teacherId);

        return $qb->getQuery()->getResult();
    }

    public function findStudentById($id)
    {
        $qb = $this->createQueryBuilder('s');

        $qb->where('s.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();

    }

//    /**
//     * @return StudentFixtures[] Returns an array of StudentFixtures objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StudentFixtures
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
