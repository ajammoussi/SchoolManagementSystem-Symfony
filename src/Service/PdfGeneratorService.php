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
        $requestRepository = $this->entityManager->getRepository(Request::class);

        // Fetch all requests from the database
        $requests = $requestRepository->findAll();

        foreach ($requests as $request) {
            // Generate the PDF and save it to the file system
            $this->createpdf($request);
        }
    }

    private function createpdf($data)
    {
        $data = $data->toArray();
        $data['birthdate'] = $data['birthdate']->format('Y-m-d');
        $filename = $data['email'] . '.pdf';

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

        // Save the PDF file in the 'src/pdf' directory
        file_put_contents(__DIR__ . '/../pdf/' . $filename, $pdfContent);

        return ['filename' => $filename, 'content' => $pdfContent];
    }

}
