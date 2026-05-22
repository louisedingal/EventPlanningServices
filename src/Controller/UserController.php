<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventRequest;
use App\Entity\ServicePackage;
use App\Entity\Theme;
use App\Entity\User;
use App\Entity\Venue;
use App\Form\UserManagementFormType;
use App\Repository\UserRepository;
use App\Service\ActivityLogService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/users')]
final class UserController extends AbstractController
{
    #[Route('', name: 'app_user_index', methods: ['GET'])]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $query = $request->query->get('q');
        $status = $request->query->get('status');
        
        $qb = $userRepository->createQueryBuilder('u');
        
        $conditions = [];
        $parameters = [];
        
        if ($query) {
            $conditions[] = '(u.email LIKE :query OR u.name LIKE :query)';
            $parameters['query'] = '%' . $query . '%';
        }
        
        if ($status) {
            $conditions[] = 'u.status = :status';
            $parameters['status'] = $status;
        }
        
        if (!empty($conditions)) {
            $qb->where(implode(' AND ', $conditions));
            foreach ($parameters as $key => $value) {
                $qb->setParameter($key, $value);
            }
        }
        
        $users = $qb->orderBy('u.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult();

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'query' => $query,
            'selectedStatus' => $status,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher,
        ActivityLogService $activityLogService
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $user = new User();
        $form = $this->createForm(UserManagementFormType::class, $user, [
            'is_edit' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle role - convert single choice to array
            $role = $form->get('roles')->getData();
            $user->setRoles([$role]);
            
            // Hash password
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }
            
            // Set createdAt if not set
            if (!$user->getCreatedAt()) {
                $user->setCreatedAt(new \DateTimeImmutable());
            }
            
            $entityManager->persist($user);
            $entityManager->flush();

            // Log activity
            $currentUser = $this->getUser();
            if ($currentUser) {
                $activityLogService->logCreate(
                    $currentUser,
                    'User',
                    $user->getId(),
                    [
                        'email' => $user->getEmail(),
                        'role' => $role,
                        'status' => $user->getStatus(),
                    ],
                    "Created user account: {$user->getEmail()} ({$role})"
                );
            }

            $this->addFlash('success', 'User account created successfully.');
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/staff', name: 'app_user_staff', methods: ['GET'])]
    public function staff(Request $request, UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $query = $request->query->get('q');
        
        $allUsers = $userRepository->findAll();
        $staff = [];
        
        foreach ($allUsers as $user) {
            $roles = $user->getRoles();
            // Include both ROLE_STAFF and ROLE_ADMIN as staff
            if (in_array('ROLE_STAFF', $roles, true) || in_array('ROLE_ADMIN', $roles, true)) {
                if (!$query || stripos($user->getEmail(), $query) !== false || stripos($user->getName() ?? '', $query) !== false) {
                    $staff[] = $user;
                }
            }
        }

        return $this->render('user/index.html.twig', [
            'users' => $staff,
            'query' => $query,
            'selectedStatus' => null,
            'showStaffOnly' => true,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher,
        ActivityLogService $activityLogService
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $oldData = [
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'roles' => $user->getRoles(),
            'status' => $user->getStatus(),
        ];
        
        // Get primary role for form
        $originalRoles = $user->getRoles();
        $primaryRole = 'ROLE_USER';
        if (in_array('ROLE_ADMIN', $originalRoles, true)) {
            $primaryRole = 'ROLE_ADMIN';
        } elseif (in_array('ROLE_STAFF', $originalRoles, true)) {
            $primaryRole = 'ROLE_STAFF';
        }
        
        $form = $this->createForm(UserManagementFormType::class, $user, [
            'is_edit' => true,
            'reset_password' => $request->query->get('reset_password') === '1',
        ]);
        
        // Set the initial role value in the form (since roles field is not mapped)
        $form->get('roles')->setData($primaryRole);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle role
            $role = $form->get('roles')->getData();
            $user->setRoles([$role]);
            
            // Handle password reset if provided (only if the field exists)
            if ($form->has('plainPassword')) {
                $plainPassword = $form->get('plainPassword')->getData();
                if ($plainPassword) {
                    $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
                    $user->setPassword($hashedPassword);
                }
            }
            
            $entityManager->flush();

            // Log activity
            $currentUser = $this->getUser();
            if ($currentUser) {
                $activityLogService->logUpdate(
                    $currentUser,
                    'User',
                    $user->getId(),
                    [
                        'old' => $oldData,
                        'new' => [
                            'email' => $user->getEmail(),
                            'name' => $user->getName(),
                            'role' => $role,
                            'status' => $user->getStatus(),
                        ],
                    ],
                    "Updated user account: {$user->getEmail()}"
                );
            }

            $this->addFlash('success', 'User account updated successfully.');
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        ActivityLogService $activityLogService,
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        // Prevent deleting yourself
        if ($user === $this->getUser()) {
            $this->addFlash('error', 'You cannot delete your own account.');
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
        
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            try {
                $userData = [
                    'email' => $user->getEmail(),
                    'name' => $user->getName(),
                    'roles' => $user->getRoles(),
                ];
                $userId = $user->getId();

                // Detach foreign keys so the user row can be removed (MySQL FK constraints)
                foreach ($entityManager->getRepository(Event::class)->findBy(['createdBy' => $user]) as $event) {
                    $event->setCreatedBy(null);
                }
                foreach ($entityManager->getRepository(Theme::class)->findBy(['createdBy' => $user]) as $theme) {
                    $theme->setCreatedBy(null);
                }
                foreach ($entityManager->getRepository(Venue::class)->findBy(['createdBy' => $user]) as $venue) {
                    $venue->setCreatedBy(null);
                }
                foreach ($entityManager->getRepository(ServicePackage::class)->findBy(['createdBy' => $user]) as $package) {
                    $package->setCreatedBy(null);
                }
                foreach ($entityManager->getRepository(EventRequest::class)->findBy(['requestedBy' => $user]) as $eventRequest) {
                    $eventRequest->setRequestedBy(null);
                }

                // Flush relationship updates first so FK checks pass even on strict DB settings.
                $entityManager->flush();

                // Now safe to delete the user
                $entityManager->remove($user);
                $entityManager->flush();

                // Log activity
                $currentUser = $this->getUser();
                if ($currentUser) {
                    $activityLogService->logDelete(
                        $currentUser,
                        'User',
                        $userId,
                        $userData,
                        "Deleted user account: {$userData['email']}"
                    );
                }

                $this->addFlash('success', 'User account deleted successfully.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred while deleting the user: ' . $e->getMessage());
            }
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/toggle-status', name: 'app_user_toggle_status', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function toggleStatus(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        ActivityLogService $activityLogService
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        // Prevent disabling yourself
        if ($user === $this->getUser() && $request->request->get('status') === 'disabled') {
            $this->addFlash('error', 'You cannot disable your own account.');
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
        
        if ($this->isCsrfTokenValid('toggle-status'.$user->getId(), $request->request->get('_token'))) {
            $oldStatus = $user->getStatus();
            $newStatus = $request->request->get('status', 'active');
            
            $user->setStatus($newStatus);
            $entityManager->flush();

            // Log activity
            $currentUser = $this->getUser();
            if ($currentUser) {
                $activityLogService->logUpdate(
                    $currentUser,
                    'User',
                    $user->getId(),
                    [
                        'old' => ['status' => $oldStatus],
                        'new' => ['status' => $newStatus],
                    ],
                    "Changed user status: {$user->getEmail()} from {$oldStatus} to {$newStatus}"
                );
            }

            $this->addFlash('success', "User status changed to {$newStatus}.");
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}

