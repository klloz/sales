<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Cart\CartRepository;
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
        $id = Uuid::v4();
        $this->cartRepository->save(new Cart($id));

       return $this->json(
           data: [
               'id' => $id->__toString(),
           ],
           status: Response::HTTP_CREATED
       );
    }
}
