<?php

namespace App\Repository;

use App\Entity\Absence;
use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Student;
/**
 * @extends ServiceEntityRepository<Absence>
 */
class AbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Absence::class);
    }

    public function findAbsencesByStudentId($id)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('a', 'COUNT(a.absencedate) AS absenceNumber')
            ->innerJoin(Course::class, 'c', 'WITH', 'a.course = c.id')
            ->where('a.student = :id')
            ->groupBy('a.course')
            ->setParameter('id', $id);
        return $qb->getQuery()->getResult();

    }
    public function absencesStatistics(): array
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('a.absencedate,count(a) AS nbAbsences')
            ->groupBy('a.absencedate');
        return $qb->getQuery()->getResult();

    }
    // public function getAdminAbsencesList(): array
    // {
    //     $qb = $this->createQueryBuilder('a');
    //     $qb->select('a.student.id AS studentID, CONCAT(s.firstname, \' \', s.lastname) AS studentname, c.coursename, a.absencedate')
    //         ->Join(Student::class, 's', 'WITH', 's.id = a.student.id')
    //         ->Join(Course::class, 'c', 'WITH', 'c.id = a.course')
    //         ->groupBy('a.absencedate');
    //     return $qb->getQuery()->getResult();

    // }
    

    
    

//    /**
//     * @return Absence[] Returns an array of Absence objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Absence
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
