<?php

namespace App\Controller;

use App\Entity\EventRequest;
use App\Form\ChangePasswordFormType;
use App\Repository\ActivityLogRepository;
use App\Repository\EventRepository;
use App\Repository\EventRequestRepository;
use App\Repository\ServicePackageRepository;
use App\Repository\ThemeRepository;
use App\Repository\UserRepository;
use App\Repository\VenueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class AdminController extends AbstractController
{
    #[Route('/staff-dashboard', name: 'app_staff_dashboard')]
    public function staffDashboard(
        EventRepository $eventRepository,
        ThemeRepository $themeRepository,
        ServicePackageRepository $servicePackageRepository,
        VenueRepository $venueRepository,
        EventRequestRepository $eventRequestRepository
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Staff access required.');
        // Keep workflows distinct: admins should use the admin dashboard instead.
        if ($this->isGranted('ROLE_ADMIN')) {
            $this->addFlash(
                'info',
                'You are signed in as an administrator. Please use the main Admin Dashboard for admin workflows.'
            );

            return $this->redirectToRoute('app_admin_dashboard');
        }
        
        $user = $this->getUser();
        
        // Get only staff's own records
        $myEvents = $eventRepository->findBy(['createdBy' => $user], ['eventDate' => 'DESC']);
        $myThemes = $themeRepository->findBy(['createdBy' => $user], ['name' => 'ASC']);
        $myVenues = $venueRepository->findBy(['createdBy' => $user], ['name' => 'ASC']);
        $myServicePackages = $servicePackageRepository->findBy(['createdBy' => $user], ['name' => 'ASC']);
        
        // Calculate metrics for staff's own records
        $totalMyEvents = count($myEvents);
        $totalMyRevenue = array_sum(array_map(fn($event) => $event->getPrice(), $myEvents));
        $averageMyEventPrice = $totalMyEvents > 0 ? $totalMyRevenue / $totalMyEvents : 0;
        $totalMyRecords = $totalMyEvents + count($myThemes) + count($myVenues) + count($myServicePackages);
        
        // Get recent events (last 5)
        $recentEvents = array_slice($myEvents, 0, 5);
        
        // Get pending event requests (staff can also see and mark them as done)
        $pendingEventRequests = $eventRequestRepository->findPending();
        $totalPendingRequests = count($pendingEventRequests);
        $paidRequests = $eventRequestRepository->findPaid();
        $paymentRevenue = $eventRequestRepository->totalPaidAmount();

        return $this->render('admin/staff_dashboard.html.twig', [
            'user' => $user,
            'isAdmin' => $this->isGranted('ROLE_ADMIN'),
            'currentUser' => $user,
            'totalMyEvents' => $totalMyEvents,
            'totalMyRevenue' => $totalMyRevenue,
            'averageMyEventPrice' => $averageMyEventPrice,
            'totalMyRecords' => $totalMyRecords,
            'recentEvents' => $recentEvents,
            'myThemes' => count($myThemes),
            'myVenues' => count($myVenues),
            'myServicePackages' => count($myServicePackages),
            'pendingEventRequests' => $pendingEventRequests,
            'totalPendingRequests' => $totalPendingRequests,
            'paymentRevenue' => $paymentRevenue,
            'paidRequests' => $paidRequests,
        ]);
    }

    #[Route('/', name: 'app_admin_dashboard')]
    public function dashboard(
        EventRepository $eventRepository,
        UserRepository $userRepository,
        ThemeRepository $themeRepository,
        ServicePackageRepository $servicePackageRepository,
        VenueRepository $venueRepository,
        ActivityLogRepository $activityLogRepository,
        EventRequestRepository $eventRequestRepository
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Access denied. Admin access required.');
        // Get all events for analytics
        $allEvents = $eventRepository->findAll();
        
        // Calculate key metrics
        $totalEvents = count($allEvents);
        $totalRevenue = array_sum(array_map(fn($event) => $event->getPrice(), $allEvents));
        $averageEventPrice = $totalEvents > 0 ? $totalRevenue / $totalEvents : 0;
        
        // Get total users
        $allUsers = $userRepository->findAll();
        $totalUsers = count($allUsers);
        
        // Get total staff (users with ROLE_STAFF or ROLE_ADMIN, excluding regular users)
        $totalStaff = 0;
        foreach ($allUsers as $user) {
            $roles = $user->getRoles();
            if (in_array('ROLE_STAFF', $roles, true) || in_array('ROLE_ADMIN', $roles, true)) {
                $totalStaff++;
            }
        }
        
        // Get total records (Events + Themes + ServicePackages + Venues)
        $totalThemes = count($themeRepository->findAll());
        $totalServicePackages = count($servicePackageRepository->findAll());
        $totalVenues = count($venueRepository->findAll());
        $totalRecords = $totalEvents + $totalThemes + $totalServicePackages + $totalVenues;
        
        // Get recent activities from ActivityLog entity
        $recentActivities = $activityLogRepository->findBy([], ['createdAt' => 'DESC'], 10);
        
        // Get pending event requests
        $pendingEventRequests = $eventRequestRepository->findPending();
        $totalPendingRequests = count($pendingEventRequests);
        $paymentRevenue = $eventRequestRepository->totalPaidAmount();
        
        // Group events by type
        $eventsByType = [];
        foreach ($allEvents as $event) {
            $type = $event->getEventType();
            if (!isset($eventsByType[$type])) {
                $eventsByType[$type] = 0;
            }
            $eventsByType[$type]++;
        }
        
        // Group events by month for chart data
        $eventsByMonth = [];
        foreach ($allEvents as $event) {
            $month = $event->getEventDate() ? $event->getEventDate()->format('Y-m') : 'Unknown';
            if (!isset($eventsByMonth[$month])) {
                $eventsByMonth[$month] = 0;
            }
            $eventsByMonth[$month]++;
        }
        
        // Get recent events (last 10)
        $recentEvents = array_slice($allEvents, -10);
        
        // Calculate monthly revenue
        $monthlyRevenue = [];
        foreach ($allEvents as $event) {
            $month = $event->getEventDate() ? $event->getEventDate()->format('Y-m') : 'Unknown';
            if (!isset($monthlyRevenue[$month])) {
                $monthlyRevenue[$month] = 0;
            }
            $monthlyRevenue[$month] += $event->getPrice();
        }
        
        // Pre-compute max values for Twig (Twig base doesn't include a max filter)
        $maxCountByType = 0;
        foreach ($eventsByType as $count) {
            if ($count > $maxCountByType) {
                $maxCountByType = $count;
            }
        }
        
        $maxMonthlyRevenue = 0;
        foreach ($monthlyRevenue as $revenue) {
            if ($revenue > $maxMonthlyRevenue) {
                $maxMonthlyRevenue = $revenue;
            }
        }
        
        return $this->render('admin/dashboard.html.twig', [
            'totalEvents' => $totalEvents,
            'totalRevenue' => $totalRevenue,
            'averageEventPrice' => $averageEventPrice,
            'eventsByType' => $eventsByType,
            'eventsByMonth' => $eventsByMonth,
            'monthlyRevenue' => $monthlyRevenue,
            'maxCountByType' => $maxCountByType,
            'maxMonthlyRevenue' => $maxMonthlyRevenue,
            'recentEvents' => $recentEvents,
            'allEvents' => $allEvents,
            'totalUsers' => $totalUsers,
            'totalStaff' => $totalStaff,
            'totalRecords' => $totalRecords,
            'recentActivities' => $recentActivities,
            'pendingEventRequests' => $pendingEventRequests,
            'totalPendingRequests' => $totalPendingRequests,
            'paymentRevenue' => $paymentRevenue,
        ]);
    }
    
    
    #[Route('/events', name: 'app_admin_events')]
    public function events(EventRepository $eventRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $events = $eventRepository->findAll();
        
        return $this->render('admin/events.html.twig', [
            'events' => $events,
        ]);
    }
    
    #[Route('/analytics', name: 'app_admin_analytics')]
    public function analytics(EventRepository $eventRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $allEvents = $eventRepository->findAll();
        
        // More detailed analytics
        $eventsByType = [];
        $revenueByType = [];
        $eventsByVenue = [];
        
        foreach ($allEvents as $event) {
            $type = $event->getEventType();
            $venue = $event->getVenue() ?? 'Unknown';
            
            // Count by type
            if (!isset($eventsByType[$type])) {
                $eventsByType[$type] = 0;
                $revenueByType[$type] = 0;
            }
            $eventsByType[$type]++;
            $revenueByType[$type] += $event->getPrice();
            
            // Count by venue
            if (!isset($eventsByVenue[$venue])) {
                $eventsByVenue[$venue] = 0;
            }
            $eventsByVenue[$venue]++;
        }
        
        return $this->render('admin/analytics.html.twig', [
            'eventsByType' => $eventsByType,
            'revenueByType' => $revenueByType,
            'eventsByVenue' => $eventsByVenue,
            'totalEvents' => count($allEvents),
        ]);
    }
    
    #[Route('/profile', name: 'app_admin_profile')]
    public function profile(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $user = $this->getUser();
        
        return $this->render('admin/profile.html.twig', [
            'user' => $user,
        ]);
    }
    
    #[Route('/change-password', name: 'app_admin_change_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $user = $this->getUser();
        
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Verify current password
            $currentPassword = $form->get('currentPassword')->getData();
            
            if (!$userPasswordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('error', 'Current password is incorrect.');
                return $this->render('admin/change_password.html.twig', [
                    'form' => $form,
                ]);
            }
            
            // Set new password
            $newPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);
            
            $entityManager->flush();
            
            $this->addFlash('success', 'Your password has been changed successfully.');
            return $this->redirectToRoute('app_admin_profile');
        }
        
        return $this->render('admin/change_password.html.twig', [
            'form' => $form,
        ]);
    }
    
    #[Route('/records', name: 'app_admin_records')]
    public function records(
        Request $request,
        EventRepository $eventRepository,
        ThemeRepository $themeRepository,
        ServicePackageRepository $servicePackageRepository,
        VenueRepository $venueRepository,
        EventRequestRepository $eventRequestRepository
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Access denied. Admin access required.');
        $type = $request->query->get('type', 'all');
        $query = $request->query->get('q', '');
        
        $events = [];
        $themes = [];
        $venues = [];
        $servicePackages = [];
        $paidRequests = [];
        
        if ($type === 'all' || $type === 'events') {
            if ($query) {
                $events = $eventRepository->search($query, null, null);
            } else {
                $events = $eventRepository->findBy([], ['id' => 'DESC']);
            }
        }
        
        if ($type === 'all' || $type === 'themes') {
            $themes = $themeRepository->findBy([], ['name' => 'ASC']);
            if ($query) {
                $themes = array_filter($themes, function($theme) use ($query) {
                    return stripos($theme->getName() ?? '', $query) !== false 
                        || stripos($theme->getDescription() ?? '', $query) !== false;
                });
            }
        }
        
        if ($type === 'all' || $type === 'venues') {
            $venues = $venueRepository->findBy([], ['name' => 'ASC']);
            if ($query) {
                $venues = array_filter($venues, function($venue) use ($query) {
                    return stripos($venue->getName() ?? '', $query) !== false 
                        || stripos($venue->getAddress() ?? '', $query) !== false;
                });
            }
        }
        
        if ($type === 'all' || $type === 'service_packages') {
            $servicePackages = $servicePackageRepository->findBy([], ['name' => 'ASC']);
            if ($query) {
                $servicePackages = array_filter($servicePackages, function($package) use ($query) {
                    return stripos($package->getName() ?? '', $query) !== false 
                        || stripos($package->getDescription() ?? '', $query) !== false;
                });
            }
        }

        if ($type === 'all' || $type === 'payments') {
            $paidRequests = $eventRequestRepository->findPaid();
        }
        
        $totalRecords = count($events) + count($themes) + count($venues) + count($servicePackages) + count($paidRequests);
        
        return $this->render('admin/records.html.twig', [
            'events' => $events,
            'themes' => $themes,
            'venues' => $venues,
            'servicePackages' => $servicePackages,
            'paidRequests' => $paidRequests,
            'selectedType' => $type,
            'query' => $query,
            'totalRecords' => $totalRecords,
        ]);
    }
    
    #[Route('/pending-requests', name: 'app_admin_pending_requests')]
    public function pendingRequests(EventRequestRepository $eventRequestRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $pendingEventRequests = $eventRequestRepository->findPending();
        $totalPendingRequests = count($pendingEventRequests);
        
        return $this->render('admin/pending_requests.html.twig', [
            'pendingEventRequests' => $pendingEventRequests,
            'totalPendingRequests' => $totalPendingRequests,
        ]);
    }
    
    #[Route('/event-request/{id}/mark-done', name: 'app_admin_event_request_mark_done', methods: ['POST'])]
    public function markEventRequestDone(
        int $id,
        Request $request,
        EventRequestRepository $eventRequestRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $token = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('mark_done_' . $id, $token)) {
            $this->addFlash('error', 'Invalid security token.');
            return $this->redirectToRoute('app_admin_pending_requests');
        }
        
        $eventRequest = $eventRequestRepository->find($id);
        
        if (!$eventRequest) {
            $this->addFlash('error', 'Event request not found.');
            return $this->redirectToRoute('app_admin_pending_requests');
        }
        
        if ($eventRequest->getStatus() !== 'pending') {
            $this->addFlash('error', 'This request is not pending.');
            return $this->redirectToRoute('app_admin_pending_requests');
        }
        
        $eventRequest->setStatus('completed');
        $eventRequest->setAdminNotes(
            'Your request has been reviewed by our team. We will reach out to you shortly with next steps.'
        );
        $entityManager->flush();
        
        $this->addFlash('success', 'Event request marked as completed. The customer can see the update in the mobile app.');
        return $this->redirectToRoute('app_admin_pending_requests');
    }
}
