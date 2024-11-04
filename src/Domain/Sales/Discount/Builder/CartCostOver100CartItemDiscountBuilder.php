<?php

declare(strict_types=1);

namespace App\Domain\Sales\Discount\Builder;

use App\Domain\Sales\Cart\Calculator\CostCalculator;
use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Discount\Discount;

class CartCostOver100CartItemDiscountBuilder implements CartDiscountBuilder
{
    public function applies(Cart $cart): bool
    {
        return CostCalculator::calculateTotalAmount($cart) >= 10000;
    }

    public function build(Cart $cart): Discount
    {
        return new Discount(
            (int) \round(CostCalculator::calculateTotalAmount($cart) * 0.1),
            self::description()
        );
    }

    private static function description(): string
    {
        return '10% discount';
    }
}
