<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Domain\Sales\Cart\CartRepository;
use App\Infrastructure\Repository\Sales\Cart\CartDetails\Serializer\CartDetailsNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[AsController]
class GetCartDetailsController extends AbstractController
{
    public function __construct(
        private readonly CartRepository $cartRepository,
        private readonly CartDetailsNormalizer $cartDetailsNormalizer,
    ) {
    }

    #[Route(
        path: '/cart/{id}',
        name: 'cart_details_get',
        methods: 'GET'
    )]
    public function __invoke(string $id): JsonResponse
    {
        if (!Uuid::isValid($id)) {
            return $this->json([
                'exception' => 'Invalid uuid',
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($cart = $this->cartRepository->findById(Uuid::fromString($id))) {
            return $this->json($this->cartDetailsNormalizer->normalize($cart));
        }

        return $this->json([
            'exception' => 'Cart not found',
        ], Response::HTTP_NOT_FOUND);
    }
}
