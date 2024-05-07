<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\CourseVideo;
use App\Entity\Schedule;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Repository\AbsenceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student')]
class StudentController extends AbstractController
{
    private $manager;
    private $teacherRepository;
    private $studentRepository;
    private $courseRepository;
    private $scheduleRepository;
    private $courseVideoRepository;

    public function __construct(private ManagerRegistry $doctrine, private readonly AbsenceRepository $absenceRepository)
    {
        $this->manager = $doctrine->getManager();
        $this->teacherRepository = $doctrine->getRepository(Teacher::class);
        $this->studentRepository = $doctrine->getRepository(Student::class);
        $this->courseRepository = $doctrine->getRepository(Course::class);
        $this->scheduleRepository = $doctrine->getRepository(Schedule::class);
        $this->courseVideoRepository = $doctrine->getRepository(CourseVideo::class);
    }
    #[Route('/dashboard/{id<\d+>}', name: 'app_dashboard_student')]
    public function dashboard($id): Response
    {
        $student = $this->studentRepository->findStudentById($id);
        return $this->render('student/dashboard.html.twig',
            ['student' => $student]);
    }

    #[Route('/absences/{id<\d+>}', name: 'app_absences_student')]
    public function absencesOfStudent($id): Response
    {
        $student = $this->studentRepository->findStudentById($id);
        $absences = $this->absenceRepository->findAbsencesByStudentId($id);
        // Convert absences to array
        foreach ($absences as &$absence) {
            $course = ($absence['0'])->getCourse()->getCourseName();
            unset($absence['0']);
            $absence['course'] = $course;
        }
        return $this->render('student/absencesEtudiant.html.twig',
            ['student' => $student, 'absences' => $absences]);
    }

    #[Route('/schedule/{id<\d+>}', name: 'app_schedule_student')]
    public function scheduleOfStudent($id): Response
    {
        $student = $this->studentRepository->findStudentById($id);
        $schedule = $this->scheduleRepository->findSchedulesByFieldAndLevel($student->getField(), $student->getStudylevel());
        $schedule = array_map(function($schedule) {
            return $schedule->toArray();
        }, $schedule);
        foreach($schedule as &$item_schedule) {
            $item_schedule["course_id"] = ($item_schedule["course_id"])->getId();
            $item_schedule["start_date"] = $item_schedule["start_date"]->format('Y-m-d');
            $item_schedule["start_time"] = $item_schedule["start_time"]->format('H:i:s');
            $item_schedule["end_time"] = $item_schedule["end_time"]->format('H:i:s');
            $item_schedule["instructor_id"] = ($item_schedule["instructor_id"])->getId();
            $item_schedule["expiry_date"] = $item_schedule["expiry_date"]->format('Y-m-d');
        }
        return $this->render('student/scheduleStudent.html.twig',
            ['student' => $student, 'schedule' => $schedule]);
    }

    #[Route('/courses/{id<\d+>}', name: 'app_courses_student')]
    public function coursesOfStudent($id): Response
    {
        $student = $this->studentRepository->findStudentById($id);
        $courseVideos = $this->courseVideoRepository->findCourseVideosByFieldAndLevel($student->getField(), $student->getStudylevel());
        // Convert courses to array
        array_map(function($courseVideo) {
            return $courseVideo->toArray();
        }, $courseVideos);
        return $this->render('student/videoCourses.html.twig',
            ['student' => $student, 'courseVideos' => $courseVideos]);
    }
}
