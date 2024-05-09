<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\Course;
use App\Entity\Schedule;
use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/teacher')]
class TeacherController extends AbstractController
{
    private $manager;
    private $teacherRepository;
    private $studentRepository;
    private $courseRepository;
    private $scheduleRepository;

    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $doctrine->getManager();
        $this->teacherRepository = $doctrine->getRepository(Teacher::class);
        $this->studentRepository = $doctrine->getRepository(Student::class);
        $this->courseRepository = $doctrine->getRepository(Course::class);
        $this->scheduleRepository = $doctrine->getRepository(Schedule::class);
    }

    #[Route('/dashboard/{id<\d+>}', name: 'app_dashboard_teacher')]
    public function dashboard($id): Response
    {
        $teacher = $this->teacherRepository->findTeacherById($id);
        return $this->render('teacher/dashboard.html.twig',
            ['teacher' => $teacher]);
    }

    #[Route('/students/{id<\d+>}', name: 'app_students_teacher')]
    public function studentsOfTeacher($id): Response
    {
        $teacher = $this->teacherRepository->findTeacherById($id);
        $students = $this->studentRepository->findStudentsByTeacherId($id);
        // Convert students to array
        $students = array_map(function($student) {
            return $student[0]->toArray() + ["enrolledcourse" => $student["enrolledcourse"]];
        }, $students);
        //convert the birthdate into string
        foreach ($students as &$student) {
            $student["birthdate"] = $student["birthdate"]->format('Y-m-d');
        }
        $courses = $this->courseRepository->findCoursesByTeacherId($id);
        // Convert courses to array
        $courses = array_map(function($course) {
            return $course->toArray();
        }, $courses);
        //fetching the id from teacher
        foreach ($courses as &$course) {
            $course["teacher"] = ($course["teacher"])->getId();
        }
        return $this->render('teacher/students.html.twig',
            ['teacher' => $teacher, 'students' => $students, 'courses' => $courses]);
    }

    #[Route('/schedule/{id<\d+>}', name: 'app_schedule_teacher')]
    public function scheduleTeacher($id): Response
    {
        $teacher = $this->teacherRepository->findTeacherById($id);
        $schedule = $this->scheduleRepository->findScheduleByTeacherId($id);
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
        return $this->render('teacher/schedule.html.twig',
            ['teacher' => $teacher, 'schedule' => $schedule]);
    }

    #[Route('students/mark-absence/{id<\d+>}', name: 'app_mark_absence', methods: ['POST'])]
    public function markAbsence($id): Response
    {
        $studentID = $_POST['studentID'];
        $courseID = $_POST['courseID'];
        $date = $_POST['absenceDate'];
        $teacherID = $id;
        $absence = new Absence();
        $student = $this->studentRepository->find($studentID);
        $absence->setStudent($student);
        $course = $this->courseRepository->find($courseID);
        $absence->setCourse($course);
        $absenceDate = new \DateTime($date);
        $absence->setAbsenceDate($absenceDate);
        $this->manager->persist($absence);
        $this->manager->flush();
        // add a success flash
        $this->addFlash('success', "Student of ID: $studentID was marked absent.");
        return $this->redirectToRoute('app_students_teacher', ['id' => $teacherID]);
    }
}
