<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Cart\CartRepository;
use App\Domain\Sales\Cart\Cost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[AsController]
class CreateCartController extends AbstractController
{
    public function __construct(private readonly CartRepository $cartRepository)
    {
    }

    #[Route(
        path: '/cart',
        name: 'cart_post',
        methods: 'POST'
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $cart = Cart::create(Uuid::v4());
        $this->cartRepository->save($cart);

       return $this->json([
               'id' => $cart->getId()->__toString(),
           ],
           Response::HTTP_CREATED
       );
    }
}
