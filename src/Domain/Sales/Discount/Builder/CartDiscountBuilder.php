<?php

declare(strict_types=1);

namespace App\Domain\Sales\Discount\Builder;

use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Discount\Discount;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.cart_discount_builder')]
interface CartDiscountBuilder
{
    public function applies(Cart $cart): bool;

    public function build(Cart $cart): Discount;
}
