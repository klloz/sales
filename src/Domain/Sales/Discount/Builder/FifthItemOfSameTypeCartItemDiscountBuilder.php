<?php

declare(strict_types=1);

namespace App\Domain\Sales\Discount\Builder;

use App\Domain\Sales\Cart\CartItem;
use App\Domain\Sales\Discount\Discount;

class FifthItemOfSameTypeCartItemDiscountBuilder implements CartItemDiscountBuilder
{
    public function applies(CartItem $cartItem): bool
    {
        return $cartItem->getQuantity() > 4;
    }

    public function build(CartItem $cartItem): Discount
    {
        $count = (int) \floor($cartItem->getQuantity()/5);

        return new Discount(
            $cartItem->getProduct()->getCost() * $count,
            self::description($count),
            $cartItem->getProduct()
        );
    }

    private static function description(int $count): string
    {
        return \sprintf('(%dx) Each fifth item is for free', $count);
    }
}
