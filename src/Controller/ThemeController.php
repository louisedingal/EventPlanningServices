<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Form\ThemeType;
use App\Repository\ThemeRepository;
use App\Service\ActivityLogService;
use App\Service\ThemeSampleImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/themes')]
final class ThemeController extends AbstractController
{
    private const MAX_SAMPLE_IMAGES = 8;

    public function __construct(
        private readonly ThemeSampleImageUploader $sampleImageUploader,
    ) {
    }
    #[Route(name: 'app_theme_index', methods: ['GET'])]
    public function index(Request $request, ThemeRepository $themeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        $query = $request->query->get('q');
        $type = $request->query->get('type');
        $allowed = ['Birthday', 'Wedding'];
        $currentType = in_array($type, $allowed, true) ? $type : null;

        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        
        // Staff can see all records (including admin's), Admin can see all
        $themes = $themeRepository->search($query, $currentType);

        return $this->render('theme/index.html.twig', [
            'themes' => $themes,
            'currentType' => $currentType,
            'query' => $query,
            'isAdmin' => $isAdmin,
            'currentUser' => $user,
        ]);
    }

    #[Route('/options', name: 'app_theme_options', methods: ['GET'])]
    public function options(Request $request, ThemeRepository $themeRepository): JsonResponse
    {
        $type = $request->query->get('type');
        $allowed = ['Birthday', 'Wedding'];
        if (!in_array($type, $allowed, true)) {
            return $this->json(['options' => []]);
        }

        $themes = $themeRepository->findBy(['eventType' => $type], ['name' => 'ASC']);
        $options = array_map(static fn(Theme $t) => [
            'value' => $t->getName(),
            'label' => $t->getName(),
        ], $themes);

        return $this->json(['options' => $options]);
    }

    #[Route('/new/select', name: 'app_theme_select_type', methods: ['GET'])]
    public function selectType(): Response
    {
        return $this->render('theme/select_type.html.twig');
    }

    #[Route('/new/{type}', name: 'app_theme_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ActivityLogService $activityLogService, string $type): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        $allowed = ['Birthday', 'Wedding'];
        if (!in_array($type, $allowed, true)) {
            return $this->redirectToRoute('app_theme_select_type');
        }

        $theme = new Theme();
        $theme->setEventType($type);

        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ensure type remains set even if not in form
            $theme->setEventType($type);

            $user = $this->getUser();
            if ($user) {
                $theme->setCreatedBy($user);
            }

            $this->applySampleImagesFromForm($form, $theme);

            $entityManager->persist($theme);
            $entityManager->flush();

            if ($user) {
                $activityLogService->logCreate(
                    $user,
                    'Theme',
                    $theme->getId(),
                    [
                        'name' => $theme->getName(),
                        'eventType' => $theme->getEventType(),
                    ],
                    "Created theme: {$theme->getName()} ({$theme->getEventType()})"
                );
            }

            return $this->redirectToRoute('app_theme_index', ['type' => $type], Response::HTTP_SEE_OTHER);
        }

        return $this->render('theme/new.html.twig', [
            'theme' => $theme,
            'form' => $form,
            'chosenType' => $type,
        ]);
    }

    #[Route('/{id}', name: 'app_theme_show', methods: ['GET'])]
    public function show(Theme $theme): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        
        // Staff can view all records (including admin's)
        
        return $this->render('theme/show.html.twig', [
            'theme' => $theme,
            'isAdmin' => $isAdmin,
            'currentUser' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_theme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Theme $theme, EntityManagerInterface $entityManager, ActivityLogService $activityLogService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $user = $this->getUser();
        // Staff can only edit their own records
        if ($user && !$this->isGranted('ROLE_ADMIN')) {
            if ($theme->getCreatedBy() !== $user) {
                $this->addFlash('error', 'You can only edit your own records.');
                return $this->redirectToRoute('app_theme_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        
        $oldData = [
            'name' => $theme->getName(),
            'eventType' => $theme->getEventType(),
        ];

        $form = $this->createForm(ThemeType::class, $theme, ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applySampleImagesFromForm($form, $theme, true);
            $entityManager->flush();

            $user = $this->getUser();
            if ($user) {
                $activityLogService->logUpdate(
                    $user,
                    'Theme',
                    $theme->getId(),
                    [
                        'old' => $oldData,
                        'new' => [
                            'name' => $theme->getName(),
                            'eventType' => $theme->getEventType(),
                        ],
                    ],
                    "Updated theme: {$theme->getName()}"
                );
            }

            return $this->redirectToRoute('app_theme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('theme/edit.html.twig', [
            'theme' => $theme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_theme_delete', methods: ['POST'])]
    public function delete(Request $request, Theme $theme, EntityManagerInterface $entityManager, ActivityLogService $activityLogService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_STAFF', null, 'Access denied. Admin or Staff access required.');
        
        $user = $this->getUser();
        // Staff can only delete their own records
        if ($user && !$this->isGranted('ROLE_ADMIN')) {
            if ($theme->getCreatedBy() !== $user) {
                $this->addFlash('error', 'You can only delete your own records.');
                return $this->redirectToRoute('app_theme_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        
        if ($this->isCsrfTokenValid('delete'.$theme->getId(), $request->getPayload()->getString('_token'))) {
            $themeData = [
                'name' => $theme->getName(),
                'eventType' => $theme->getEventType(),
            ];
            $themeId = $theme->getId();
            $samplePaths = $theme->getSampleImagePaths();

            $entityManager->remove($theme);
            $entityManager->flush();

            $this->sampleImageUploader->deleteMany($samplePaths);

            $user = $this->getUser();
            if ($user) {
                $activityLogService->logDelete(
                    $user,
                    'Theme',
                    $themeId,
                    $themeData,
                    "Deleted theme: {$themeData['name']}"
                );
            }
        }

        return $this->redirectToRoute('app_theme_index', [], Response::HTTP_SEE_OTHER);
    }

    private function applySampleImagesFromForm(FormInterface $form, Theme $theme, bool $isEdit = false): void
    {
        if ($isEdit && $form->has('removeSampleImages') && $form->get('removeSampleImages')->getData()) {
            $this->sampleImageUploader->deleteMany($theme->getSampleImagePaths());
            $theme->setSampleImagePaths([]);
        }

        if (!$form->has('sampleImageFiles')) {
            return;
        }

        $files = $form->get('sampleImageFiles')->getData();
        if (!is_array($files)) {
            $files = $files instanceof UploadedFile ? [$files] : [];
        }

        $paths = $theme->getSampleImagePaths();
        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }
            if (count($paths) >= self::MAX_SAMPLE_IMAGES) {
                break;
            }
            $paths[] = $this->sampleImageUploader->upload($file, $theme->getName());
        }

        $theme->setSampleImagePaths($paths);
    }
}
