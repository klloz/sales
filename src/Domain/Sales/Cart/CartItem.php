<?php

declare(strict_types=1);

namespace App\Domain\Sales\Cart;

class CartItem
{
    public function __construct(private readonly int $productId, private readonly int $quantity)
    {
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
