<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\Course;
use App\Entity\PdfFile;
use App\Entity\Schedule;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\Admin;
use App\Entity\User;
use App\Repository\PdfFileRepository;
use App\Service\PdfGeneratorService;
use Doctrine\Persistence\ManagerRegistry;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use App\Entity\Request as RequestEntity;

use function PHPSTORM_META\map;

#[Route('/admin')]
class AdminController extends AbstractController
{
    private $manager;
    private $teacherRepository;
    private $adminRepository;
    private $studentRepository;
    private $courseRepository;
    private $scheduleRepository;
    private $absenceRepository;
    private $pdfFileRepository;
    private $requestRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(private ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher)
    {
        $this->manager = $doctrine->getManager();
        $this->teacherRepository = $doctrine->getRepository(Teacher::class);
        $this->studentRepository = $doctrine->getRepository(Student::class);
        $this->courseRepository = $doctrine->getRepository(Course::class);
        $this->scheduleRepository = $doctrine->getRepository(Schedule::class);
        $this->absenceRepository = $doctrine->getRepository(Absence::class);
        $this->pdfFileRepository = $doctrine->getRepository(PdfFile::class);
        $this->requestRepository = $doctrine->getRepository(RequestEntity::class);
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/dashboard/{id<\d+>}', name: 'admin_dashboard')]
    public function dashboard(Admin $admin): Response
    {   
        $studentsStatistics = $this->studentRepository->statsStudentsPerYear();
        $statsStudentsPerGender= $this->studentRepository->statsStudentsPerGender();
        $absencesStatistics = $this->absenceRepository->absencesStatistics();
        $fieldStatistics = $this->studentRepository->fieldStatistics();
        $teachersStatistics= $this->courseRepository->teachersStatistics();
        return $this->render('admin/overview.html.twig',
            [
                'admin' => $admin ,
                'studentsStatistics' => $studentsStatistics ,
                'statsStudentsPerGender' => $statsStudentsPerGender ,
                'absencesStatistics' => $absencesStatistics ,
                'fieldStatistics' => $fieldStatistics ,
                'teachersStatistics' => $teachersStatistics
            ]);
    }
    #[Route('/students/{id<\d+>}', name: 'admin_students')]
    public function studentsListAdmin(Admin $admin): Response
    {
        $studentsList=$this->studentRepository->findAll();
        $studentsList=array_map(function($student){
            return $student->toArray();
        },$studentsList);
        return $this->render('admin/studentsList.html.twig',
            [
                'admin' => $admin , 
                'students' => $studentsList
            ]);
    }
    #[Route('/teachers/{id<\d+>}', name: 'admin_teachers')]
    public function teachersListAdmin(Admin $admin): Response
    {   
        $teachersList=$this->teacherRepository->findAll();
        $teachersList=array_map(function($teacher){
            return $teacher->toArray();
        },$teachersList);
        return $this->render('admin/teachersList.html.twig',
            [
                'admin' => $admin , 
                'teachers' => $teachersList
            ]);
    }
    #[Route('/absences/{id<\d+>}', name: 'admin_absences')]
    public function absencesListAdmin(Admin $admin): Response
    {   
        $absencesList=$this->absenceRepository->findAll();
        $UniqueCourseNames=$this->courseRepository->findUniqueCourseNames();
        $absencesList=array_map(function($absence){
            return $absence->toArray();
        },$absencesList);
        $absencesList=array_map(function($absence){
            $temp=[ 'studentID'=> $absence["student"]["id"] ,
                'studentname' => $absence["student"]["firstName"].' '.$absence["student"]["lastName"] ,
                'coursename' => $absence["course"]["coursename"] ,
                'absencedate' => $absence["absencedate"] 
            ];
            
            return $temp  ;
        },$absencesList);
        return $this->render('admin/absencesList.html.twig',
            [
                'admin' => $admin , 
                'absences' => $absencesList ,
                'UniqueCourseNames' => $UniqueCourseNames
            ]);
    }

    #[Route('/pdf/{filename}', name: 'admin_applications_files')]
    public function pdfView($filename, PdfFileRepository $pdfFileRepository)
    {
        // Get the path to the 'src/pdf' directory
        $pdfDirectory = __DIR__ . '/../pdf';

        // Create a BinaryFileResponse instance with the path to the PDF file
        $response = new BinaryFileResponse($pdfDirectory . '/' . $filename);

        // Set the Content-Type header to 'application/pdf'
        $response->headers->set('Content-Type', 'application/pdf');

        // Optionally force the browser to download the file
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE, // Display inline instead of download
            $filename
        );

        return $response;
    }


    #[Route('/pdfFormat/{id<\d+>}', name: 'admin_applications_pdf')]
    public function pdfGeneration(Admin $admin)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        //collect requests from the database
        $requests = $this->requestRepository->findAll();
        foreach ($requests as $request) {
            $data = $request->toArray();
            $data['birthdate'] = $data['birthdate']->format('Y-m-d');

            // In this case, we want to write the file in the 'src/pdf' directory
            $publicDirectory = $this->getParameter('kernel.project_dir') . '/src/pdf';
            // e.g /var/www/project/src/pdf/mypdf.pdf
            $pdfFilepath =  $publicDirectory . '/' . $data['email'] . '.pdf';

            // Check if the file already exists
            if (file_exists($pdfFilepath)) {
                // If the file already exists, skip this iteration
                continue;
            }

            // Retrieve the HTML generated in our twig file
            $html = $this->renderView('admin/pdfFormat.html.twig', [
                'data' => $data
            ]);

            // Load HTML to Dompdf
            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            // Store PDF Binary Data
            $output = $dompdf->output();

            // Write file to the desired path
            file_put_contents($pdfFilepath, $output);
        }

        // Send some text response
        return new Response("The PDF file has been succesfully generated !");
    }

    #[Route('/applications/{id<\d+>}', name: 'admin_applications')]
    public function applicationsAdmin(Admin $admin, PdfGeneratorService $pdfGeneratorService): Response
    {
        $this->pdfGeneration($admin);

        $requests = $this->requestRepository->findAll();

        // Get the path to the 'src/pdf' directory
        $pdfDirectory = __DIR__ . '/../pdf';

        // Get all files in the 'src/pdf' directory
        $pdfFiles = array_diff(scandir($pdfDirectory), array('..', '.'));

        // Prepend the directory path to each filename
        $pdfFiles = array_map(function($filename) use ($pdfDirectory) {
            return $filename;
        }, $pdfFiles);

        return $this->render('admin/applicationsAdmin.html.twig', [
            'admin' => $admin,
            'pdfFiles' => $pdfFiles,
            'requests' => $requests
        ]);
    }

    #[Route('/applications/handle/{id<\d+>}/{filename}', name: 'admin_applications_handle', methods: ['POST'])]
    public function handleApplication(string $filename, HttpRequest $request, $id): RedirectResponse
    {
        $action = $request->request->get('action');
        $fileName = $request->request->get('fileName');
        $pdfData = $this->requestRepository->findOneByEmail(substr($filename, 0, -4));


        if ($action === 'accept') {
            // Accept the submission
            $this->addFlash('success', 'The submission has been accepted');

            $student = new Student();
            $student->setFirstName($pdfData->getFirstname());
            $student->setLastName($pdfData->getLastname());
            $student->setEmail($pdfData->getEmail());
            $student->setPassword("pass123");
            $student->setPhone($pdfData->getPhone());
            $student->setAddress($pdfData->getAddress());
            $student->setBirthdate($pdfData->getBirthdate());
            $student->setGender($pdfData->getGender());
            $student->setNationality($pdfData->getNationality());
            $student->setField($pdfData->getProgram());
            $student->setStudylevel(1);
            $student->setClass(1);

            $this->manager->persist($student);

            $this->manager->remove($pdfData);
            $this->manager->flush();

            $userObj = new User();
            $userObj->setEmail($pdfData->getEmail());
            $userObj->setRoles(['ROLE_STUDENT']);

            //hash the password with the same algorithm symfony uses to compare
            $hashedPassword = $this->passwordHasher->hashPassword($userObj, $student->getPassword());
            $userObj->setPassword($hashedPassword);

            $this->manager->persist($userObj);

            $this->manager->flush();

            $filePath = __DIR__ . '/../pdf/' . $fileName;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        } else if ($action === 'refuse') {
            // Refuse the submission
            $this->addFlash('warning', 'The submission has been refused');
            $this->manager->remove($pdfData);
            $this->manager->flush();

            $filePath = __DIR__ . '/../pdf/' . $fileName;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Redirect to the applications admin page
        return $this->redirectToRoute('admin_applications', ['id' => $id]);
    }




    // #[Route('/teachers/{id<\d+>}', name: 'app_admin_teachers')]
    // public function adminTeacher($id): Response
    // {
    //     $teacher = $this->teacherRepository->findAll();
    //     $students = $this->studentRepository->findStudentsByTeacherId($id);
    //     // Convert students to array
    //     $students = array_map(function($student) {
    //         return $student[0]->toArray() + ["enrolledcourse" => $student["enrolledcourse"]];
    //     }, $students);
    //     //convert the birthdate into string
    //     foreach ($students as &$student) {
    //         $student["birthdate"] = $student["birthdate"]->format('Y-m-d');
    //     }
    //     $courses = $this->courseRepository->findCoursesByTeacherId($id);
    //     // Convert courses to array
    //     $courses = array_map(function($course) {
    //         return $course->toArray();
    //     }, $courses);
    //     //fetching the id from teacher
    //     foreach ($courses as &$course) {
    //         $course["teacher"] = ($course["teacher"])->getId();
    //     }
    //     return $this->render('teacher/students.html.twig',
    //         ['teacher' => $teacher, 'students' => $students, 'courses' => $courses]);
    // }

    // #[Route('/schedule/{id<\d+>}', name: 'app_schedule_teacher')]
    // public function scheduleTeacher($id): Response
    // {
    //     $teacher = $this->teacherRepository->findTeacherById($id);
    //     $schedule = $this->scheduleRepository->findScheduleByTeacherId($id);
    //     $schedule = array_map(function($schedule) {
    //         return $schedule->toArray();
    //     }, $schedule);
    //     foreach($schedule as &$item_schedule) {
    //         $item_schedule["course_id"] = ($item_schedule["course_id"])->getId();
    //         $item_schedule["start_date"] = $item_schedule["start_date"]->format('Y-m-d');
    //         $item_schedule["start_time"] = $item_schedule["start_time"]->format('H:i:s');
    //         $item_schedule["end_time"] = $item_schedule["end_time"]->format('H:i:s');
    //         $item_schedule["instructor_id"] = ($item_schedule["instructor_id"])->getId();
    //         $item_schedule["expiry_date"] = $item_schedule["expiry_date"]->format('Y-m-d');
    //     }
    //     return $this->render('teacher/schedule.html.twig',
    //         ['teacher' => $teacher, 'schedule' => $schedule]);
    // }

    // #[Route('students/mark-absence/{id<\d+>}', name: 'app_mark_absence', methods: ['POST'])]
    // public function markAbsence($id): Response
    // {
    //     $studentID = $_POST['studentID'];
    //     $courseID = $_POST['courseID'];
    //     $date = $_POST['absenceDate'];
    //     $teacherID = $id;
    //     $absence = new Absence();
    //     $student = $this->studentRepository->find($studentID);
    //     $absence->setStudent($student);
    //     $course = $this->courseRepository->find($courseID);
    //     $absence->setCourse($course);
    //     $absenceDate = new \DateTime($date);
    //     $absence->setAbsenceDate($absenceDate);
    //     $this->manager->persist($absence);
    //     $this->manager->flush();
    //     // add a success flash
    //     $this->addFlash('success', "Student of ID: $studentID was marked absent.");
    //     return $this->redirectToRoute('app_students_teacher', ['id' => $teacherID]);
    // }
}
