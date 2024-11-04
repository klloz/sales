<?php

declare(strict_types=1);

namespace App\Domain\Sales\Discount;

use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Discount\Filter\BestDiscountWinsFilter;

class DiscountsProvider
{
    public function __construct(
        private readonly iterable $cartDiscountBuilders,
        private readonly iterable $cartItemDiscountBuilders,
    ) {
    }

    /**
     * @return Discount[]
     */
    public function provide(Cart $cart): array
    {
        $cartDiscounts = $this->buildCartDiscounts($cart);
        $cartItemsDiscounts = $this->buildCartItemsDiscounts($cart);

        $bestCartDiscount = BestDiscountWinsFilter::filter($cartDiscounts);
        $bestCartDiscountValue = $bestCartDiscount->getValue();

        $bestCartItemsDiscounts = [];
        foreach ($cartItemsDiscounts as $itemDiscounts) {
            $bestCartItemsDiscounts[] = BestDiscountWinsFilter::filter($itemDiscounts);
        }
        $bestCartItemsDiscountsValue = \array_sum(\array_map(
            static fn (Discount $discount) => $discount->getValue(),
            $bestCartItemsDiscounts
        ));

        if ($bestCartDiscountValue > $bestCartItemsDiscountsValue) {
            return [$bestCartDiscount];
        } else {
            // TODO To clarify what if the values are equal, but...
            // ... a greater number of smaller discounts should be more attractive to customers than one large one
            return $bestCartItemsDiscounts;
        }
    }

    /**
     * @return Discount[]
     */
    private function buildCartDiscounts(Cart $cart): array
    {
        $cartDiscounts = [];
        foreach ($this->cartDiscountBuilders as $discountBuilder) {
            $cartDiscounts[] = $discountBuilder->build($cart);
        }

        return $cartDiscounts;
    }

    /**
     * @return array<int, array<Discount>>
     */
    private function buildCartItemsDiscounts(Cart $cart): array
    {
        $cartItemsDiscounts = [];
        foreach ($this->cartItemDiscountBuilders as $discountBuilder) {
            foreach ($cart->getItems() as $item) {
                if ($discountBuilder->applies($item)) {
                    $cartItemsDiscounts[$item->getProduct()->getId()][] = $discountBuilder->build($item);
                }
            }
        }

        return $cartItemsDiscounts;
    }
}
