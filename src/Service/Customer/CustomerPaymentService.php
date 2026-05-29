<?php

namespace App\Service\Customer;

use App\Entity\EventRequest;
use App\Entity\Payment;
use App\Entity\User;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;

final class CustomerPaymentService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PaymentRepository $paymentRepository,
    ) {
    }

    /**
     * @return list<Payment>
     */
    public function listForUser(User $user): array
    {
        return $this->paymentRepository->findByUser($user);
    }

    public function getForUser(User $user, int $id): Payment
    {
        $payment = $this->paymentRepository->find($id);
        if (!$payment || $payment->getUser()?->getId() !== $user->getId()) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Payment not found.');
        }

        return $payment;
    }

    public function recordMobileApproval(
        User $user,
        EventRequest $request,
        float $amount,
        string $receiptNumber,
    ): Payment {
        $payment = new Payment();
        $payment->setUser($user);
        $payment->setEventRequest($request);
        $payment->setAmount(number_format($amount, 2, '.', ''));
        $payment->setReceiptNumber($receiptNumber);
        $payment->setSource(Payment::SOURCE_MOBILE);
        $payment->setStatus(Payment::STATUS_APPROVED);
        $payment->setCreatedAt(new \DateTimeImmutable());

        $request->setPaymentTransaction($payment);
        $this->entityManager->persist($payment);

        return $payment;
    }

    public function serialize(Payment $payment): array
    {
        $request = $payment->getEventRequest();

        return [
            'id' => $payment->getId(),
            'amount' => (float) $payment->getAmount(),
            'currency' => $payment->getCurrency(),
            'receiptNumber' => $payment->getReceiptNumber(),
            'status' => $payment->getStatus(),
            'source' => $payment->getSource(),
            'sourceLabel' => $payment->getSourceLabel(),
            'createdAt' => $payment->getCreatedAt()?->format(\DateTimeInterface::ATOM),
            'eventRequest' => $request ? [
                'id' => $request->getId(),
                'eventType' => $request->getEventType(),
                'status' => $request->getStatus(),
                'preferredDate' => $request->getPreferredDate()?->format('Y-m-d'),
            ] : null,
        ];
    }

    public function serializeFromEventRequest(EventRequest $request): array
    {
        $payment = $request->getPaymentTransaction();
        if ($payment) {
            return [
                'id' => $payment->getId(),
                'amount' => (float) $payment->getAmount(),
                'approvedAt' => $payment->getCreatedAt()?->format(\DateTimeInterface::ATOM),
                'receiptNumber' => $payment->getReceiptNumber(),
            ];
        }

        return [
            'id' => null,
            'amount' => $request->getPaymentAmount() !== null ? (float) $request->getPaymentAmount() : null,
            'approvedAt' => $request->getPaymentApprovedAt()?->format(\DateTimeInterface::ATOM),
            'receiptNumber' => $request->getReceiptNumber(),
        ];
    }
}
