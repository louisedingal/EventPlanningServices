<?php

namespace App\Controller;

use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/payments')]
final class PaymentController extends AbstractController
{
    #[Route(name: 'app_payment_index', methods: ['GET'])]
    public function index(Request $request, PaymentRepository $paymentRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');

        $query = trim((string) $request->query->get('q', ''));
        $payments = $paymentRepository->findAllApproved();

        if ($query !== '') {
            $needle = mb_strtolower($query);
            $payments = array_values(array_filter(
                $payments,
                static function ($payment) use ($needle): bool {
                    $receipt = mb_strtolower($payment->getReceiptNumber() ?? '');
                    $email = mb_strtolower($payment->getUser()?->getEmail() ?? '');
                    $eventType = mb_strtolower($payment->getEventRequest()?->getEventType() ?? '');
                    $requestId = (string) ($payment->getEventRequest()?->getId() ?? '');

                    return str_contains($receipt, $needle)
                        || str_contains($email, $needle)
                        || str_contains($eventType, $needle)
                        || str_contains($requestId, $needle);
                }
            ));
        }

        $totalAmount = array_sum(array_map(
            static fn ($payment) => (float) $payment->getAmount(),
            $payments
        ));

        return $this->render('admin/payments/index.html.twig', [
            'payments' => $payments,
            'query' => $query,
            'totalAmount' => $totalAmount,
            'isAdmin' => $this->isGranted('ROLE_ADMIN'),
            'currentUser' => $this->getUser(),
        ]);
    }
}
