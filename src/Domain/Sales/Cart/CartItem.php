<?php

declare(strict_types=1);

namespace App\Domain\Sales\Cart;

use App\Domain\Sales\Product\Product;

class CartItem
{
    public function __construct(private readonly Product $product, private readonly int $quantity)
    {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
