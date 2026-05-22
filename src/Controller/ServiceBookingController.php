<?php

namespace App\Controller;

use App\Entity\EventRequest;
use App\Form\ServiceBookingType;
use App\Repository\ServicePackageRepository;
use App\Repository\ThemeRepository;
use App\Service\EventRequestNotifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/services')]
final class ServiceBookingController extends AbstractController
{
    #[Route('/{id}/book', name: 'app_service_book', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function book(
        int $id,
        Request $request,
        ServicePackageRepository $servicePackageRepository,
        ThemeRepository $themeRepository,
        EntityManagerInterface $entityManager,
        EventRequestNotifier $eventRequestNotifier,
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $package = $servicePackageRepository->find($id);
        if (!$package) {
            throw $this->createNotFoundException('This service package is no longer available.');
        }

        $catalogThemes = $themeRepository->findForCustomerCatalog();
        $form = $this->createForm(ServiceBookingType::class, null, [
            'themes' => $catalogThemes,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $notes = [];
            if (!empty($data['contactPhone'])) {
                $notes[] = 'Contact phone: '.$data['contactPhone'];
            }
            if (!empty($data['specialRequests'])) {
                $notes[] = trim((string) $data['specialRequests']);
            }
            $notes[] = sprintf(
                'Service booking for package "%s" (₱%s).',
                $package->getName(),
                number_format((float) $package->getPrice(), 2)
            );

            $eventRequest = new EventRequest();
            $eventRequest->setRequestedBy($this->getUser());
            $eventRequest->setServicePackage($package);
            $eventRequest->setEventType('Service: '.$package->getName());
            $eventRequest->setPreferredDate($data['preferredDate']);
            $eventRequest->setPreferredTime($data['preferredTime']);
            $eventRequest->setEstimatedGuestCount($data['estimatedGuestCount'] ?? null);
            $eventRequest->setPreferredVenue($data['preferredVenue'] ?? null);
            $eventRequest->setTheme($data['theme'] ?? null);
            $eventRequest->setBudget(number_format((float) $package->getPrice(), 2, '.', ''));
            $eventRequest->setSpecialRequests(implode("\n\n", $notes));
            $eventRequest->setSource(EventRequest::SOURCE_WEB);

            $entityManager->persist($eventRequest);
            $entityManager->flush();

            $eventRequestNotifier->notifyNew($eventRequest);

            $this->addFlash(
                'success',
                sprintf(
                    'Your booking request for "%s" was sent! Our team will confirm your date and time soon.',
                    $package->getName()
                )
            );

            return $this->redirectToRoute('app_landing', ['_fragment' => 'services']);
        }

        return $this->render('landing/service_book.html.twig', [
            'package' => $package,
            'form' => $form,
        ]);
    }
}
