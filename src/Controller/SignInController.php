<?php

namespace App\Controller;

use App\Form\SignInFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignInController extends AbstractController
{
    #[Route('/signin', name: 'signin')]
    public function signIn(Request $request): Response
    {
        $form = $this->createForm(SignInFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('/authenticate');
        }

        return $this->render('signin.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/authenticate', name: 'authenticate', methods: ['POST'])]
    public function authenticate(Request $request): Response
    {
        return $this->redirectToRoute('dashboard');
    }
}
