<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $email = (new Email())
                ->from($formData['email'])
                ->to('contactisat@gmail.com')
                ->subject('New Contact Message')
                ->html(
                    $this->renderView(
                        'emails/contact.html.twig',
                        ['data' => $formData]
                    )
                );

            $mailer->send($email);

            $this->addFlash('success', 'Your message has been sent successfully!');

            return $this->redirectToRoute('app_landingpage');
        }

        return $this->render('landingpage/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
