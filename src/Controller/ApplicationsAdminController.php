<?php

namespace App\Controller;

use App\Service\PdfGeneratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationsAdminController extends AbstractController
{
    #[Route('/applicationsAdmin', name: 'applications_admin')]
    public function index(PdfGeneratorService $pdfGeneratorService): Response
    {
        $pdfGeneratorService->generateAndStorePdf();

        $entityManager = $this->getDoctrine()->getManager();

        $pdfFilesRepository = $entityManager->getRepository(Pdffiles::class);

        $pdfFiles = $pdfFilesRepository->findAll();

        return $this->render('applicationsadmin.html.twig', [
            'pdfFiles' => $pdfFiles,
        ]);
    }
}
