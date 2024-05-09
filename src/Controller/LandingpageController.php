<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactFormType;

class LandingpageController extends AbstractController
{
    #[Route('/', name: 'app_landingpage')]
    public function index(): Response
    {
        $form = $this->createForm(ContactFormType::class);

        return $this->render('landingpage/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

