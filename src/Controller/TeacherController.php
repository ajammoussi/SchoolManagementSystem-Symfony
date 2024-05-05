<?php

namespace App\Controller;

use App\Entity\Course;
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

    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $doctrine->getManager();
        $this->teacherRepository = $doctrine->getRepository(Teacher::class);
        $this->studentRepository = $doctrine->getRepository(Student::class);
        $this->courseRepository = $doctrine->getRepository(Course::class);
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
}
