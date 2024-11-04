<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Sales\Discount;

use App\Domain\Sales\Discount\Discount;
use App\Domain\Sales\Discount\Filter\BestDiscountWinsFilter;
use PHPUnit\Framework\TestCase;

class BestDiscountWinsFilterTest extends TestCase
{
    public function testFilter(): void
    {
        $discounts = [
            new Discount(123, 'Discount 1'),
            new Discount(456, 'Discount 2'),
            new Discount(999999, 'Discount 3'),
        ];

        $this->assertEquals('Discount 3', BestDiscountWinsFilter::filter($discounts)->getDescription());
    }

    public function testEmpty(): void
    {
        $this->assertNull(BestDiscountWinsFilter::filter([]));
    }
}
