<?php

namespace App\Controller\Api\Customer;

use App\Api\Customer\CustomerApiResponse;
use App\Repository\EventRepository;
use App\Repository\ServicePackageRepository;
use App\Repository\ThemeRepository;
use App\Repository\VenueRepository;
use App\Service\Customer\CustomerCatalogSerializer;
use App\Service\Customer\PortfolioCatalogSerializer;
use App\Service\Portfolio\PortfolioCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/customer/catalog')]
#[IsGranted('ROLE_USER')]
final class CustomerCatalogController extends AbstractController
{
    public function __construct(
        private VenueRepository $venueRepository,
        private ThemeRepository $themeRepository,
        private ServicePackageRepository $servicePackageRepository,
        private EventRepository $eventRepository,
        private CustomerCatalogSerializer $serializer,
        private PortfolioCatalog $portfolioCatalog,
        private PortfolioCatalogSerializer $portfolioSerializer,
    ) {
    }

    #[Route('', name: 'api_customer_catalog_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return CustomerApiResponse::success([
            'venues' => array_map(
                fn ($v) => $this->serializer->venue($v),
                $this->venueRepository->findBy([], ['name' => 'ASC'])
            ),
            'themes' => array_map(
                fn ($t) => $this->serializer->theme($t, $this->getBaseUrl()),
                $this->themeRepository->findBy([], ['name' => 'ASC'])
            ),
            'packages' => array_map(
                fn ($p) => $this->serializer->package($p, $this->getBaseUrl()),
                $this->servicePackageRepository->findBy([], ['name' => 'ASC'])
            ),
            'events' => array_map(
                fn ($e) => $this->serializer->event($e),
                $this->eventRepository->findBy([], ['eventDate' => 'DESC'], 20)
            ),
        ]);
    }

    #[Route('/venues', name: 'api_customer_catalog_venues', methods: ['GET'])]
    public function venues(): JsonResponse
    {
        $items = array_map(
            fn ($v) => $this->serializer->venue($v),
            $this->venueRepository->findBy([], ['name' => 'ASC'])
        );

        return CustomerApiResponse::items($items);
    }

    #[Route('/venues/{id}', name: 'api_customer_catalog_venue', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function venue(int $id): JsonResponse
    {
        $venue = $this->venueRepository->find($id);
        if (!$venue) {
            throw new NotFoundHttpException('Venue not found.');
        }

        return CustomerApiResponse::success($this->serializer->venue($venue));
    }

    #[Route('/themes', name: 'api_customer_catalog_themes', methods: ['GET'])]
    public function themes(Request $request): JsonResponse
    {
        $eventType = $request->query->get('eventType');
        $filterType = is_string($eventType) && in_array($eventType, ['Birthday', 'Wedding'], true)
            ? $eventType
            : null;

        $baseUrl = $this->getBaseUrl();
        $items = array_map(
            fn ($t) => $this->serializer->theme($t, $baseUrl),
            $this->themeRepository->findForCustomerCatalog($filterType)
        );

        return CustomerApiResponse::items($items);
    }

    #[Route('/themes/{id}', name: 'api_customer_catalog_theme', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function theme(int $id): JsonResponse
    {
        $theme = $this->themeRepository->find($id);
        if (!$theme) {
            throw new NotFoundHttpException('Theme not found.');
        }

        return CustomerApiResponse::success($this->serializer->theme($theme, $this->getBaseUrl()));
    }

    #[Route('/packages', name: 'api_customer_catalog_packages', methods: ['GET'])]
    public function packages(): JsonResponse
    {
        $baseUrl = $this->getBaseUrl();
        $items = array_map(
            fn ($p) => $this->serializer->package($p, $baseUrl),
            $this->servicePackageRepository->findBy([], ['name' => 'ASC'])
        );

        return CustomerApiResponse::items($items);
    }

    #[Route('/packages/{id}', name: 'api_customer_catalog_package', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function package(int $id): JsonResponse
    {
        $package = $this->servicePackageRepository->find($id);
        if (!$package) {
            throw new NotFoundHttpException('Package not found.');
        }

        return CustomerApiResponse::success($this->serializer->package($package, $this->getBaseUrl()));
    }

    #[Route('/portfolio', name: 'api_customer_catalog_portfolio', methods: ['GET'])]
    public function portfolio(): JsonResponse
    {
        $baseUrl = $this->getBaseUrl();
        $items = array_map(
            fn ($item) => $this->portfolioSerializer->item($item, $baseUrl),
            $this->portfolioCatalog->all()
        );

        return CustomerApiResponse::items($items);
    }

    #[Route('/portfolio/{id}', name: 'api_customer_catalog_portfolio_item', methods: ['GET'])]
    public function portfolioItem(string $id): JsonResponse
    {
        $item = $this->portfolioCatalog->find($id);
        if (!$item) {
            throw new NotFoundHttpException('Portfolio item not found.');
        }

        return CustomerApiResponse::success(
            $this->portfolioSerializer->item($item, $this->getBaseUrl())
        );
    }

    #[Route('/events', name: 'api_customer_catalog_events', methods: ['GET'])]
    public function events(): JsonResponse
    {
        $items = array_map(
            fn ($e) => $this->serializer->event($e),
            $this->eventRepository->findBy([], ['eventDate' => 'DESC'])
        );

        return CustomerApiResponse::items($items);
    }

    #[Route('/events/{id}', name: 'api_customer_catalog_event', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function event(int $id): JsonResponse
    {
        $event = $this->eventRepository->find($id);
        if (!$event) {
            throw new NotFoundHttpException('Event not found.');
        }

        return CustomerApiResponse::success($this->serializer->event($event));
    }

    private function getBaseUrl(): string
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        if ($request) {
            return $request->getSchemeAndHttpHost();
        }

        return 'http://127.0.0.1:8000';
    }
}
