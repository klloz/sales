<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Cart\CartRepository;
use App\Domain\Sales\Product\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class UpdateCartController extends AbstractController
{
    public function __construct(
        private readonly CartRepository $cartRepository,
        private readonly ProductRepository $productRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route(
        path: '/cart/{id}',
        name: 'cart_put',
        methods: 'PUT'
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $cart = $this->serializer->deserialize(
           $request->getContent(),
           Cart::class,
           JsonEncoder::FORMAT,
        );

        foreach ($cart->getItems() as $item) {
            if (!$this->productRepository->findById($item->getProductId())) {
                $cart->removeProduct($item->getProductId());
            }
        }

       $this->cartRepository->save($cart);

       return $this->json([], status: Response::HTTP_NO_CONTENT);
    }
}
