<?php

declare(strict_types=1);

namespace App\Domain\Sales\Cart\Serializer;

use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Cart\CartItem;
use App\Domain\Sales\Product\ProductRepository;
use Symfony\Component\Uid\Uuid;

class CartNormalizer
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function normalize(Cart $cart): array
    {
        $items = [];
        foreach ($cart->getItems() as $item) {
            $items[] = [
                'productId' => $item->getProduct()->getId(),
                'quantity' => $item->getQuantity(),
            ];
        }

        return [
            'id' => $cart->getId(),
            'items' => $items,
        ];
    }

    public function denormalize(array $data): Cart
    {
        $items = [];
        foreach ($data['items'] as $item) {
            if (!$product = $this->productRepository->findById($item['productId'])) {
                continue;
            }

            $items[] = new CartItem($product, $item['quantity']);
        }

        $cart = new Cart(Uuid::fromString($data['id']), $items);

        return $cart;
    }
}
