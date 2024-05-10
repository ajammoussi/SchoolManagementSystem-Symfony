<?php

namespace App\Security;

use App\Entity\Admin;
use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class CUSTOMAUTHAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    private $manager;
    private $adminRepository;
    private $teacherRepository;
    private $studentRepository;

    public function __construct(private ManagerRegistry $doctrine, private UrlGeneratorInterface $urlGenerator)
    {
        $this->adminRepository = $doctrine->getRepository(Admin::class);
        $this->teacherRepository = $doctrine->getRepository(Teacher::class);
        $this->studentRepository = $doctrine->getRepository(Student::class);
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->getPayload()->getString('email');

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->getPayload()->getString('password')),
            [
                new CsrfTokenBadge('authenticate', $request->getPayload()->getString('_csrf_token')),            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        $role = $token->getUser()->getRoles()[0];

        $email_in_user = $token->getUser()->getEmail();

        if ($role == 'ROLE_ADMIN') {
            $user_id  = $this->adminRepository->findOneBy(['email' => $email_in_user])->getId();
            return new RedirectResponse($this->urlGenerator->generate('admin_dashboard', ['id' => $user_id]));
        }
        elseif ( $role == 'ROLE_TEACHER') {
            $user_id  = $this->teacherRepository->findOneBy(['email' => $email_in_user])->getId();
            return new RedirectResponse($this->urlGenerator->generate('app_dashboard_teacher', ['id' => $user_id]));
        } elseif ( $role == 'ROLE_STUDENT') {
            $user_id  = $this->studentRepository->findOneBy(['email' => $email_in_user])->getId();
            return new RedirectResponse($this->urlGenerator->generate('app_dashboard_student', ['id' => $user_id]));
        }
        else{
            return new RedirectResponse($this->urlGenerator->generate('app_login'));
        }

    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
