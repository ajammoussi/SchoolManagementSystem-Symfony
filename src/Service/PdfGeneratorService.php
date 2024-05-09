<?php

namespace App\Service;

use App\Entity\PdfFile;
use App\Entity\Request;
use Doctrine\ORM\EntityManagerInterface;
use Fpdf\Fpdf;

class PdfGeneratorService
{
    private $entityManager;
    private $pdfFileRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->pdfFileRepository = $entityManager->getRepository(PdfFile::class);
    }

    public function generateAndStorePdf()
    {
        // Get the repository for the Request entity
        $requestRepository = $this->entityManager->getRepository('App\Entity\Request');

        // Fetch all requests from the database
        $requests = $requestRepository->findAll();


        foreach ($requests as $request) {
            $pdfFile = new PdfFile();
            $pdfData = $this->createpdf($request);

            $pdfFile->setFilename($pdfData['filename']);
            $pdfFile->setContent($pdfData['content']);

            $this->entityManager->persist($pdfFile);
        }
        $this->entityManager->flush();
    }

    private function createpdf($data)
    {
        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);

        $pdf->SetTextColor(179, 0, 0);

        $pdf->Cell(0, 10, 'Admission Application', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetTextColor(0, 0, 0);

        $pdf->Image("../assets/img/LandingPage/logo-insat.png", 1, 1, 20);

        $pdf->SetFont('Arial', '', 12);

        foreach ($data as $key => $value) {
            $pdf->SetTextColor(179, 0, 0);
            $pdf->Cell(50, 10, ucfirst(str_replace("_", " ", $key)) . ':', 0, 0);

            $pdf->SetTextColor(0, 0, 0);

            $pdf->Cell(0, 10, $value, 0, 1);
        }


        ob_start();
        $pdf->Output('S');
        $pdfContent = ob_get_clean();

        $data = $data->toArray();

        $filename = $data['email'] . '.pdf';

        return ['filename' => $filename, 'content' => $pdfContent];
    }

}
