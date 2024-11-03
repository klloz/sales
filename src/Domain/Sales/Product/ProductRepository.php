<?php

declare(strict_types=1);

namespace App\Domain\Sales\Product;

interface ProductRepository
{
    public function findById(int $id): ?Product;
}
