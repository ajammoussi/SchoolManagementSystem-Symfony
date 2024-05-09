<?php
namespace App\Controller;

use App\Entity\Course;
use App\Entity\Request;
use App\Form\SignUpFormType;
use App\Repository\AbsenceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignUpController extends AbstractController
{
    private $manager;
    private $requestRepository;

    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $doctrine->getManager();
        $this->requestRepository = $doctrine->getRepository(Request::class);
    }
    #[Route('/signup', name: 'registration')]
    public function signUp(HttpRequest $request): Response
    {
        $requestEntity = new Request();
        $form = $this->createForm(SignUpFormType::class, $requestEntity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->manager;
            $entityManager->persist($requestEntity);
            $entityManager->flush();

            $this->addFlash('notice', "You're now registered! Please wait for the admin to approve your registration.");

            // Redirect to registration landing page
            return $this->redirectToRoute('app_landingpage');
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

