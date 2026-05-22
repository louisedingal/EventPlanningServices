<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EmailVerificationService;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SecurityController extends AbstractController
{
    #[Route('/connect/google', name: 'app_connect_google_start')]
    public function connectGoogle(ClientRegistry $clientRegistry): RedirectResponse
    {
        return $clientRegistry
            ->getClient('google_main')
            // Force Google to show account picker instead of auto-selecting a previous session.
            ->redirect(['openid', 'email', 'profile'], ['prompt' => 'select_account']);
    }

    #[Route('/connect/google/check', name: 'app_connect_google_check')]
    public function connectGoogleCheck(): never
    {
        throw new \LogicException('This code should never be reached.');
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Prevent logged-in users from accessing /login
        if ($this->getUser()) {
            // Redirect based on role
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin_dashboard');
            } elseif ($this->isGranted('ROLE_STAFF')) {
                return $this->redirectToRoute('app_admin_profile');
            }
            return $this->redirectToRoute('app_landing');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        EmailVerificationService $emailVerificationService
    ): Response
    {
        // Prevent logged-in users from accessing /register
        if ($this->getUser()) {
            // Redirect based on role
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin_dashboard');
            } elseif ($this->isGranted('ROLE_STAFF')) {
                return $this->redirectToRoute('app_admin_profile');
            }
            return $this->redirectToRoute('app_landing');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Set default role (ROLE_USER is automatically added by getRoles() method)
            $user->setRoles([]);

            try {
                // Generate token and mark user as not verified yet
                $verificationToken = $emailVerificationService->generateVerificationToken();
                $user->setVerificationToken($verificationToken);
                $user->setIsVerified(false);

                // Persist before sending the email
                $entityManager->persist($user);
                $entityManager->flush();

                $verificationUrl = $this->generateUrl(
                    'app_verify_email',
                    ['token' => $verificationToken],
                    UrlGeneratorInterface::ABSOLUTE_URL
                );

                try {
                    $emailVerificationService->sendVerificationEmail($user, $verificationUrl);
                    $this->addFlash('success', 'Registration successful! Please check your email to verify your account.');
                } catch (\Throwable $mailError) {
                    error_log('[Registration] Verification email failed: ' . $mailError->getMessage());
                    $this->addFlash('warning', 'Account created, but we could not send the verification email. Use resend verification or contact support.');
                }

                return $this->redirectToRoute('app_login');
            } catch (\Exception $e) {
                // Handle database errors (e.g., duplicate email)
                $this->addFlash('error', 'Registration failed. This email may already be registered.');
            }
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

