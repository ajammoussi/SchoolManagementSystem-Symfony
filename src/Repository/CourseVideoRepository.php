<?php

namespace App\Repository;

use App\Entity\CourseVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CourseVideo>
 */
class CourseVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseVideo::class);
    }

    public function findCourseVideosByFieldAndLevel($field, $studylevel)
    {
        return $this->createQueryBuilder('cv')
            ->where('cv.field = :field')
            ->andWhere('cv.studylevel = :studylevel')
            ->setParameter('field', $field)
            ->setParameter('studylevel', $studylevel)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return CourseVideo[] Returns an array of CourseVideo objects
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

//    public function findOneBySomeField($value): ?CourseVideo
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
