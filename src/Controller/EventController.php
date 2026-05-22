<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Service\ActivityLogService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/event')]
final class EventController extends AbstractController
{
    #[Route(name: 'app_event_index', methods: ['GET'])]
    public function index(Request $request, EventRepository $eventRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        $query = $request->query->get('q');
        $eventType = $request->query->get('type');
        $venue = $request->query->get('venue');

        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        
        // Staff can see all records (including admin's), Admin can see all
        $events = $eventRepository->search($query, $eventType, $venue);
        // Get unique event types and venues for filter dropdowns from all events
        $allEvents = $eventRepository->findAll();
        
        $eventTypes = array_unique(array_map(fn($e) => $e->getEventType(), $allEvents));
        $venues = array_unique(array_filter(array_map(fn($e) => $e->getVenue(), $allEvents)));

        return $this->render('event/index.html.twig', [
            'events' => $events,
            'query' => $query,
            'selectedType' => $eventType,
            'selectedVenue' => $venue,
            'eventTypes' => $eventTypes,
            'venues' => $venues,
            'isAdmin' => $isAdmin,
            'currentUser' => $user,
        ]);
    }

    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ActivityLogService $activityLogService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if ($user) {
                $event->setCreatedBy($user);
            }
            
            $entityManager->persist($event);
            $entityManager->flush();

            if ($user) {
                $activityLogService->logCreate(
                    $user,
                    'Event',
                    $event->getId(),
                    [
                        'customerName' => $event->getCustomerName(),
                        'eventType' => $event->getEventType(),
                        'price' => $event->getPrice(),
                    ],
                    "Created event: {$event->getCustomerName()} - {$event->getEventType()}"
                );
            }

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            // Show a clear notification if date/time (or other fields) are missing/invalid
            if ($form->has('eventDate') && $form->get('eventDate')->getErrors(true)->count() > 0) {
                $this->addFlash('error', 'Date and time is required to continue.');
            }
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        
        // Staff can view all records (including admin's)
        
        return $this->render('event/show.html.twig', [
            'event' => $event,
            'isAdmin' => $isAdmin,
            'currentUser' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager, ActivityLogService $activityLogService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $user = $this->getUser();
        // Staff can only edit their own records
        if ($user && !$this->isGranted('ROLE_ADMIN')) {
            if ($event->getCreatedBy() !== $user) {
                $this->addFlash('error', 'You can only edit your own records.');
                return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        
        $oldData = [
            'customerName' => $event->getCustomerName(),
            'eventType' => $event->getEventType(),
            'price' => $event->getPrice(),
        ];

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $user = $this->getUser();
            if ($user) {
                $activityLogService->logUpdate(
                    $user,
                    'Event',
                    $event->getId(),
                    [
                        'old' => $oldData,
                        'new' => [
                            'customerName' => $event->getCustomerName(),
                            'eventType' => $event->getEventType(),
                            'price' => $event->getPrice(),
                        ],
                    ],
                    "Updated event: {$event->getCustomerName()} - {$event->getEventType()}"
                );
            }

            return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            if ($form->has('eventDate') && $form->get('eventDate')->getErrors(true)->count() > 0) {
                $this->addFlash('error', 'Date and time is required to continue.');
            }
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager, ActivityLogService $activityLogService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $user = $this->getUser();
        // Staff can only delete their own records
        if ($user && !$this->isGranted('ROLE_ADMIN')) {
            if ($event->getCreatedBy() !== $user) {
                $this->addFlash('error', 'You can only delete your own records.');
                return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->getPayload()->getString('_token'))) {
            $eventData = [
                'customerName' => $event->getCustomerName(),
                'eventType' => $event->getEventType(),
                'price' => $event->getPrice(),
            ];
            $eventId = $event->getId();

            $entityManager->remove($event);
            $entityManager->flush();

            $user = $this->getUser();
            if ($user) {
                $activityLogService->logDelete(
                    $user,
                    'Event',
                    $eventId,
                    $eventData,
                    "Deleted event: {$eventData['customerName']} - {$eventData['eventType']}"
                );
            }
        }

        return $this->redirectToRoute('app_event_index', [], Response::HTTP_SEE_OTHER);
    }
}
