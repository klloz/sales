<?php

declare(strict_types=1);

namespace App\Domain\Sales\Cart;

use Symfony\Component\Uid\Uuid;

class Cart
{
    private Cost $cost;

    /**
     * @param CartItem[] $items
     */
    public function __construct(
        private Uuid $id,
        private array $items = [],
    ) {
    }

    public static function create(Uuid $id, array $items = []): self
    {
        return new self($id, $items);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setCost(Cost $cost): void
    {
        $this->cost = $cost;
    }

    public function getCost(): Cost
    {
        return $this->cost;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
