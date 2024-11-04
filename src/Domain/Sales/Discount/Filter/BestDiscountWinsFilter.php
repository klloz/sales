<?php

declare(strict_types=1);

namespace App\Domain\Sales\Discount\Filter;

use App\Domain\Sales\Discount\Discount;

class BestDiscountWinsFilter
{
    /**
     * @param Discount[] $discounts
     */
    public static function filter(array $discounts): ?Discount
    {
        if (empty($discounts)) {
            return null;
        }

        \usort(
            $discounts,
            static fn (Discount $discount1, Discount $discount2) => $discount1->getValue() <=> $discount2->getValue()
        );

        return \end($discounts);
    }
}
