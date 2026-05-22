<?php

namespace App\Controller;

use App\Entity\EventRequest;
use App\Repository\ServicePackageRepository;
use App\Service\ContactInquiryNotifier;
use App\Service\EventRequestNotifier;
use App\Service\Portfolio\PortfolioCatalog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LandingController extends AbstractController
{
    #[Route('/', name: 'app_landing', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        ServicePackageRepository $servicePackageRepository,
        ContactInquiryNotifier $contactInquiryNotifier,
        EventRequestNotifier $eventRequestNotifier,
        #[Autowire('%env(CONTACT_FORM_EMBED_URL)%')] string $contactFormEmbedUrl,
    ): Response {
        // Contact form (public) — Mailer / Brevo SMTP (see CONTACT_* env vars)
        if ($request->isMethod('POST') && $this->isCsrfTokenValid('contact', (string) $request->request->get('_csrf_token', ''))) {
            $honeypot = trim((string) $request->request->get('website', ''));
            if ($honeypot !== '') {
                return $this->redirect($this->generateUrl('app_landing') . '#contact');
            }

            $name = trim((string) $request->request->get('name', ''));
            $email = trim((string) $request->request->get('email', ''));
            $message = trim((string) $request->request->get('message', ''));

            if ($name === '' || $email === '' || $message === '') {
                $this->addFlash('error', 'Please fill in your name, email, and message.');
            } elseif (!filter_var($email, \FILTER_VALIDATE_EMAIL)) {
                $this->addFlash('error', 'Please enter a valid email address.');
            } elseif (mb_strlen($name) > 120 || mb_strlen($message) > 5000) {
                $this->addFlash('error', 'Message is too long or name is invalid. Please shorten and try again.');
            } else {
                try {
                    $contactInquiryNotifier->send($name, $email, $message);
                    $this->addFlash('success', 'Thank you — your message was sent. We will get back to you shortly.');
                } catch (\Throwable $e) {
                    $contactInquiryNotifier->logFailure($e, $email);
                    $this->addFlash('error', 'We could not send your message right now. Please try again in a few minutes or email us directly.');
                }
            }

            return $this->redirect($this->generateUrl('app_landing') . '#contact');
        }

        // Handle event customization request submission
        if ($request->isMethod('POST') && $this->getUser()) {
            $token = $request->request->get('_token');
            if ($this->isCsrfTokenValid('event_request', $token)) {
                $eventRequest = new EventRequest();
                $eventRequest->setRequestedBy($this->getUser());
                $eventRequest->setEventType($request->request->get('eventType', ''));
                $eventRequest->setEstimatedGuestCount($request->request->get('guestCount') ? (int)$request->request->get('guestCount') : null);
                $eventRequest->setPreferredVenue($request->request->get('venue', ''));
                $eventRequest->setTheme($request->request->get('theme', ''));
                $eventRequest->setSpecialRequests($request->request->get('specialRequests', ''));
                $budgetRaw = (string) $request->request->get('budget', '');
                $budgetClean = preg_replace('/[^0-9\s.,\-]/', '', $budgetRaw);
                $budgetTrim = trim($budgetClean);
                $eventRequest->setBudget($budgetTrim !== '' ? $budgetTrim : null);
                
                $preferredDate = $request->request->get('preferredDate');
                if ($preferredDate) {
                    try {
                        $eventRequest->setPreferredDate(new \DateTime($preferredDate));
                    } catch (\Exception $e) {
                        // Invalid date, leave as null
                    }
                }

                $eventRequest->setSource(EventRequest::SOURCE_WEB);
                $entityManager->persist($eventRequest);
                $entityManager->flush();

                $eventRequestNotifier->notifyNew($eventRequest);

                $this->addFlash('success', 'Your event request has been submitted successfully! Our team will review it and get back to you soon.');
                return $this->redirectToRoute('app_landing');
            }
        }

        // Show admin-created packages to all visitors (photos visible on homepage)
        $servicePackages = $servicePackageRepository->findBy([], ['name' => 'ASC']);

        return $this->render('landing/index.html.twig', [
            'controller_name' => 'LandingController',
            'servicePackages' => $servicePackages,
            'contactFormEmbedUrl' => trim($contactFormEmbedUrl),
        ]);
    }

    #[Route('/services', name: 'app_services')]
    public function services(ServicePackageRepository $servicePackageRepository): Response
    {
        $services = $servicePackageRepository->findBy([], ['name' => 'ASC']);

        return $this->render('landing/services.html.twig', [
            'services' => $services,
        ]);
    }

    #[Route('/about', name: 'app_about', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('landing/about.html.twig');
    }

    /**
     * Full client-commission gallery (linked from landing "Our Portfolio" tiles).
     * Images: Lux Events library under public/img plus credited stock for additional variety.
     */
    #[Route('/portfolio', name: 'app_portfolio', methods: ['GET'])]
    public function portfolio(PortfolioCatalog $portfolioCatalog): Response
    {
        $items = array_map(
            static fn (array $item): array => [
                'title' => $item['title'],
                'image' => $item['image'],
            ],
            array_values(array_filter($portfolioCatalog->all(), static fn (array $item): bool => !$item['featured']))
        );

        return $this->render('landing/portfolio.html.twig', [
            'portfolio_items' => $items,
        ]);
    }
}
