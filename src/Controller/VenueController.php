<?php

namespace App\Controller;

use App\Entity\Venue;
use App\Form\VenueType;
use App\Repository\VenueRepository;
use App\Service\ActivityLogService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/venues')]
final class VenueController extends AbstractController
{
    #[Route(name: 'app_venue_index', methods: ['GET'])]
    public function index(Request $request, VenueRepository $venueRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        $query = $request->query->get('q');
        
        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        
        $qb = $venueRepository->createQueryBuilder('v');
        
        // Staff can only see their own records
        if (!$isAdmin) {
            $qb->where('v.createdBy = :creator')
               ->setParameter('creator', $user);
        }
        
        if ($query) {
            $qb->andWhere('v.name LIKE :query OR v.address LIKE :query OR v.contactInfo LIKE :query')
               ->setParameter('query', '%' . $query . '%');
        }
        
        $venues = $qb->orderBy('v.name', 'ASC')
                    ->getQuery()
                    ->getResult();

        return $this->render('venue/index.html.twig', [
            'venues' => $venues,
            'query' => $query,
            'isAdmin' => $isAdmin,
        ]);
    }

    #[Route('/new', name: 'app_venue_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ActivityLogService $activityLogService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        $venue = new Venue();
        $form = $this->createForm(VenueType::class, $venue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if ($user) {
                $venue->setCreatedBy($user);
            }
            
            $entityManager->persist($venue);
            $entityManager->flush();

            if ($user) {
                $activityLogService->logCreate(
                    $user,
                    'Venue',
                    $venue->getId(),
                    ['name' => $venue->getName()],
                    "Created venue: {$venue->getName()}"
                );
            }

            $this->addFlash('success', 'Venue created successfully.');
            return $this->redirectToRoute('app_venue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('venue/new.html.twig', [
            'venue' => $venue,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_venue_show', methods: ['GET'])]
    public function show(Venue $venue): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        
        // Staff can only view their own records
        if (!$isAdmin && $venue->getCreatedBy() !== $user) {
            $this->addFlash('error', 'You can only view your own records.');
            return $this->redirectToRoute('app_venue_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('venue/show.html.twig', [
            'venue' => $venue,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_venue_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Venue $venue, EntityManagerInterface $entityManager, ActivityLogService $activityLogService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $user = $this->getUser();
        // Staff can only edit their own records
        if ($user && !$this->isGranted('ROLE_ADMIN')) {
            if ($venue->getCreatedBy() !== $user) {
                $this->addFlash('error', 'You can only edit your own records.');
                return $this->redirectToRoute('app_venue_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        
        $oldData = ['name' => $venue->getName()];

        $form = $this->createForm(VenueType::class, $venue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $user = $this->getUser();
            if ($user) {
                $activityLogService->logUpdate(
                    $user,
                    'Venue',
                    $venue->getId(),
                    [
                        'old' => $oldData,
                        'new' => ['name' => $venue->getName()],
                    ],
                    "Updated venue: {$venue->getName()}"
                );
            }

            $this->addFlash('success', 'Venue updated successfully.');
            return $this->redirectToRoute('app_venue_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('venue/edit.html.twig', [
            'venue' => $venue,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_venue_delete', methods: ['POST'])]
    public function delete(Request $request, Venue $venue, EntityManagerInterface $entityManager, ActivityLogService $activityLogService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $user = $this->getUser();
        // Staff can only delete their own records
        if ($user && !$this->isGranted('ROLE_ADMIN')) {
            if ($venue->getCreatedBy() !== $user) {
                $this->addFlash('error', 'You can only delete your own records.');
                return $this->redirectToRoute('app_venue_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        
        if ($this->isCsrfTokenValid('delete'.$venue->getId(), $request->getPayload()->getString('_token'))) {
            $venueData = ['name' => $venue->getName()];
            $venueId = $venue->getId();

            $entityManager->remove($venue);
            $entityManager->flush();

            $user = $this->getUser();
            if ($user) {
                $activityLogService->logDelete(
                    $user,
                    'Venue',
                    $venueId,
                    $venueData,
                    "Deleted venue: {$venueData['name']}"
                );
            }

            $this->addFlash('success', 'Venue deleted successfully.');
        }

        return $this->redirectToRoute('app_venue_index', [], Response::HTTP_SEE_OTHER);
    }
}

