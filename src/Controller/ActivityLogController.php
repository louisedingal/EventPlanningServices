<?php

namespace App\Controller;

use App\Repository\ActivityLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/activity-logs')]
final class ActivityLogController extends AbstractController
{
    #[Route(name: 'app_activity_log_index', methods: ['GET'])]
    public function index(Request $request, ActivityLogRepository $activityLogRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $userEmail = $request->query->get('user');
        $action = $request->query->get('action');
        $dateFrom = $request->query->get('date_from');
        $dateTo = $request->query->get('date_to');

        // Parse dates
        $dateFromObj = null;
        $dateToObj = null;
        
        if ($dateFrom) {
            try {
                $dateFromObj = new \DateTimeImmutable($dateFrom);
            } catch (\Exception $e) {
                // Invalid date, ignore
            }
        }
        
        if ($dateTo) {
            try {
                $dateToObj = new \DateTimeImmutable($dateTo . ' 23:59:59');
            } catch (\Exception $e) {
                // Invalid date, ignore
            }
        }

        // Get filtered logs
        $logs = $activityLogRepository->search($userEmail, $action, $dateFromObj, $dateToObj, 500);

        // Get filter options
        $userEmails = $activityLogRepository->getDistinctUserEmails();
        $actions = $activityLogRepository->getDistinctActions();

        return $this->render('activity_log/index.html.twig', [
            'logs' => $logs,
            'userEmails' => $userEmails,
            'actions' => $actions,
            'selectedUser' => $userEmail,
            'selectedAction' => $action,
            'selectedDateFrom' => $dateFrom,
            'selectedDateTo' => $dateTo,
        ]);
    }

    #[Route('/{id}', name: 'app_activity_log_show', methods: ['GET'])]
    public function show(int $id, ActivityLogRepository $activityLogRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $log = $activityLogRepository->find($id);

        if (!$log) {
            throw $this->createNotFoundException('Activity log not found');
        }

        return $this->render('activity_log/show.html.twig', [
            'log' => $log,
        ]);
    }
}

