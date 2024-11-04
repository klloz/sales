<?php

declare(strict_types=1);

namespace App\Domain\Sales\Discount\Builder;

use App\Domain\Sales\Cart\CartItem;
use App\Domain\Sales\Discount\Discount;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.cart_item_discount_builder')]
interface CartItemDiscountBuilder
{
    public function applies(CartItem $cartItem): bool;

    public function build(CartItem $cartItem): Discount;
}
