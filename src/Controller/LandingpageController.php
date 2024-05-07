<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LandingpageController
{
    #[Route('/landingpage', name: 'app_landingpage')]
    public function index(): Response
    {
        return $this->render('landingpage/landingpage.html.twig', [
            'controller_name' => 'LandingpageController',
        ]);
    }
}
