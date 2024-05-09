<?php

namespace App\Controller;

use App\Entity\PdfFile;
use App\Entity\Teacher;
use App\Repository\AbsenceRepository;
use App\Service\PdfGeneratorService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationsAdminController extends AbstractController
{

    private $manager;
    private $teacherRepository;

    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $doctrine->getManager();
        $this->teacherRepository = $doctrine->getRepository(Teacher::class);
    }

    #[Route('/applicationsAdmin', name: 'applications_admin')]
    public function index(PdfGeneratorService $pdfGeneratorService): Response
    {
        $pdfGeneratorService->generateAndStorePdf();

        $entityManager = $this->manager;

        $pdfFilesRepository = $entityManager->getRepository(PdfFile::class);

        $pdfFiles = $pdfFilesRepository->findAll();

        return $this->render('applicationsadmin.html.twig', [
            'pdfFiles' => $pdfFiles,
        ]);
    }
}
