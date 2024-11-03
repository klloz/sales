<?php

declare(strict_types=1);

namespace App\Domain\Sales\Cart;

use Symfony\Component\Uid\Uuid;

class Cart
{
    /**
     * @param CartItem[] $items
     */
    public function __construct(private readonly Uuid $id, private readonly array $items = [])
    {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
