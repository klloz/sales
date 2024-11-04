<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Sales\Cart\CartDetails\Serializer;

use App\Domain\Sales\Cart\Cart;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CartDetailsNormalizer
{
    public function __construct(private readonly NormalizerInterface $normalizer)
    {
    }

    public function normalize(Cart $cart): array
    {
        $items = [];
        foreach ($cart->getItems() as $item) {
            $items[] = [
                'product' => $this->normalizer->normalize($item->getProduct(), 'array'),
                'quantity' => $item->getQuantity(),
            ];
        }

        $discounts = [];
        foreach ($cart->getCost()->discounts as $discount) {
            $discounts[] = [
                'value' => $discount->getValue(),
                'description' => $discount->getDescription(),
                'product' => [
                    'id' => $discount->getProduct()->getId(),
                ]
            ];
        }

        $cost = $this->normalizer->normalize($cart->getCost(), 'array');
        $cost['discounts'] = $discounts;

        return [
            'id' => $cart->getId(),
            'items' => $items,
            'cost' => $cost,
        ];
    }
}
