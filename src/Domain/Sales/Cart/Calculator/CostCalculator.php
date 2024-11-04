<?php

declare(strict_types=1);

namespace App\Domain\Sales\Cart\Calculator;

use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Cart\Cost;
use App\Domain\Sales\Discount\DiscountsProvider;

class CostCalculator
{
    public function __construct(private readonly DiscountsProvider $discountsProvider)
    {
    }

    public function calculateCost(Cart $cart): Cost
    {
        return new Cost(self::calculateTotalAmount($cart), $this->discountsProvider->provide($cart));
    }

    public static function calculateTotalAmount(Cart $cart): int
    {
        $totalCost = 0;
        foreach ($cart->getItems() as $item) {
            $totalCost += $item->getProduct()->getCost() * $item->getQuantity();
        }

        return $totalCost;
    }
}
