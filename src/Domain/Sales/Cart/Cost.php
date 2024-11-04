<?php

declare(strict_types=1);

namespace App\Domain\Sales\Cart;

use App\Domain\Sales\Discount\Discount;
use Symfony\Component\Serializer\Attribute\SerializedName;

class Cost
{
    /**
     * @param Discount[] $discounts
     */
    public function __construct(
        public readonly int $amount,
        public readonly array $discounts = []
    ) {
    }

    #[SerializedName('amountAfterDiscount')]
    public function getAmountAfterDiscount(): int
    {
        $discountsValue = \array_sum(\array_map(
            static fn (Discount $discount) => $discount->getValue(),
            $this->discounts
        ));

        return $this->amount - $discountsValue;
    }
}
