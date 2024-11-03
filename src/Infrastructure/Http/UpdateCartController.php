<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Domain\Sales\Cart\CartRepository;
use App\Domain\Sales\Cart\Serializer\CartNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class UpdateCartController extends AbstractController
{
    public function __construct(
        private readonly CartRepository $cartRepository,
        private readonly CartNormalizer $normalizer
    ) {
    }

    #[Route(
        path: '/cart/{id}',
        name: 'cart_put',
        methods: 'PUT'
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $cart = $this->normalizer->denormalize(
            \json_decode($request->getContent(), true)
        );

       $this->cartRepository->save($cart);

       return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
