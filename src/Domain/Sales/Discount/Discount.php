<?php

declare(strict_types=1);

namespace App\Domain\Sales\Discount;

use App\Domain\Sales\Product\Product;

class Discount
{
    public function __construct(
        private readonly int $value,
        private readonly string $description,
        private readonly ?Product $product = null
    ) {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }
}
