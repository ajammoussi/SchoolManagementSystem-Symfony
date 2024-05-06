<?php
namespace App\Controller;

use App\Entity\Request;
use App\SignUpForm\SignUpFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignUpController extends AbstractController
{
    #[Route('/signup', name: 'registration')]
    public function signUp(HttpRequest $request): Response
    {
        $requestEntity = new Request();
        $form = $this->createForm(SignUpFormType::class, $requestEntity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($requestEntity);
            $entityManager->flush();

            // Redirect to registration landing page
            //return $this->redirectToRoute('landingpage');
        }

        return $this->render('signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/registration/success', name: 'registration_success')]
    public function registrationSuccess(): Response
    {
        // Render the registration landing page
        return $this->render('registration/success.html.twig');
    }
}

