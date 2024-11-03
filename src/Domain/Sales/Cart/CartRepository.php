<?php

declare(strict_types=1);

namespace App\Domain\Sales\Cart;

use Symfony\Component\Uid\Uuid;

interface CartRepository
{
    public function save(Cart $cart): void;

    public function findById(Uuid $id): ?Cart;
}
