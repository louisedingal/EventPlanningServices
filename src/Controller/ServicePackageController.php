<?php

namespace App\Controller;

use App\Entity\ServicePackage;
use App\Form\ServicePackageType;
use App\Repository\ServicePackageRepository;
use App\Service\ActivityLogService;
use App\Service\ServicePackageImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/service-packages')]
final class ServicePackageController extends AbstractController
{
    public function __construct(
        private readonly ServicePackageImageUploader $imageUploader,
    ) {
    }

    #[Route(name: 'app_service_package_index', methods: ['GET'])]
    public function index(Request $request, ServicePackageRepository $servicePackageRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        $query = $request->query->get('q');

        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        $qb = $servicePackageRepository->createQueryBuilder('sp');

        if ($query) {
            $qb->where('sp.name LIKE :query OR sp.description LIKE :query')
               ->setParameter('query', '%'.$query.'%');
        }

        $servicePackages = $qb->orderBy('sp.name', 'ASC')
                             ->getQuery()
                             ->getResult();

        return $this->render('service_package/index.html.twig', [
            'service_packages' => $servicePackages,
            'query' => $query,
            'isAdmin' => $isAdmin,
            'currentUser' => $user,
        ]);
    }

    #[Route('/new', name: 'app_service_package_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ActivityLogService $activityLogService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        $servicePackage = new ServicePackage();
        $form = $this->createForm(ServicePackageType::class, $servicePackage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if ($user) {
                $servicePackage->setCreatedBy($user);
            }

            $this->applyImageFromForm($form, $servicePackage);

            $entityManager->persist($servicePackage);
            $entityManager->flush();

            if ($user) {
                $activityLogService->logCreate(
                    $user,
                    'ServicePackage',
                    $servicePackage->getId(),
                    ['name' => $servicePackage->getName(), 'price' => $servicePackage->getPrice()],
                    "Created service package: {$servicePackage->getName()}"
                );
            }

            $this->addFlash('success', 'Service package created successfully.');
            return $this->redirectToRoute('app_service_package_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service_package/new.html.twig', [
            'service_package' => $servicePackage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_package_show', methods: ['GET'])]
    public function show(ServicePackage $servicePackage): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');

        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        return $this->render('service_package/show.html.twig', [
            'service_package' => $servicePackage,
            'isAdmin' => $isAdmin,
            'currentUser' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_package_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServicePackage $servicePackage, EntityManagerInterface $entityManager, ActivityLogService $activityLogService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');

        $user = $this->getUser();
        if ($user && !$this->isGranted('ROLE_ADMIN')) {
            if ($servicePackage->getCreatedBy() !== $user) {
                $this->addFlash('error', 'You can only edit your own records.');
                return $this->redirectToRoute('app_service_package_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        $oldData = ['name' => $servicePackage->getName(), 'price' => $servicePackage->getPrice()];

        $form = $this->createForm(ServicePackageType::class, $servicePackage, ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applyImageFromForm($form, $servicePackage, true);

            $entityManager->flush();

            $user = $this->getUser();
            if ($user) {
                $activityLogService->logUpdate(
                    $user,
                    'ServicePackage',
                    $servicePackage->getId(),
                    [
                        'old' => $oldData,
                        'new' => ['name' => $servicePackage->getName(), 'price' => $servicePackage->getPrice()],
                    ],
                    "Updated service package: {$servicePackage->getName()}"
                );
            }

            $this->addFlash('success', 'Service package updated successfully.');
            return $this->redirectToRoute('app_service_package_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service_package/edit.html.twig', [
            'service_package' => $servicePackage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_package_delete', methods: ['POST'])]
    public function delete(Request $request, ServicePackage $servicePackage, EntityManagerInterface $entityManager, ActivityLogService $activityLogService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');

        $user = $this->getUser();
        if ($user && !$this->isGranted('ROLE_ADMIN')) {
            if ($servicePackage->getCreatedBy() !== $user) {
                $this->addFlash('error', 'You can only delete your own records.');
                return $this->redirectToRoute('app_service_package_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        if ($this->isCsrfTokenValid('delete'.$servicePackage->getId(), $request->getPayload()->getString('_token'))) {
            $packageData = ['name' => $servicePackage->getName(), 'price' => $servicePackage->getPrice()];
            $packageId = $servicePackage->getId();
            $imagePath = $servicePackage->getImagePath();

            $entityManager->remove($servicePackage);
            $entityManager->flush();

            $this->imageUploader->delete($imagePath);

            $user = $this->getUser();
            if ($user) {
                $activityLogService->logDelete(
                    $user,
                    'ServicePackage',
                    $packageId,
                    $packageData,
                    "Deleted service package: {$packageData['name']}"
                );
            }

            $this->addFlash('success', 'Service package deleted successfully.');
        }

        return $this->redirectToRoute('app_service_package_index', [], Response::HTTP_SEE_OTHER);
    }

    private function applyImageFromForm(FormInterface $form, ServicePackage $servicePackage, bool $isEdit = false): void
    {
        if ($isEdit && $form->has('removeImage') && $form->get('removeImage')->getData()) {
            $this->imageUploader->delete($servicePackage->getImagePath());
            $servicePackage->setImagePath(null);
        }

        $file = $form->get('imageFile')->getData();
        if (!$file instanceof UploadedFile) {
            return;
        }

        $this->imageUploader->delete($servicePackage->getImagePath());
        $servicePackage->setImagePath(
            $this->imageUploader->upload($file, $servicePackage->getName())
        );
    }
}
