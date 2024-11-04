<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Sales\Cart\Calculator;

use App\Domain\Sales\Cart\Calculator\CostCalculator;
use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Cart\CartItem;
use App\Domain\Sales\Product\Product;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CostCalculatorTest extends TestCase
{
    public function testCalculateTotalAmount(): void
    {
        self::assertEquals(56196, CostCalculator::calculateTotalAmount($this->prepareCart()));
    }

    private function prepareCart(): Cart
    {
        $product = new Product('Test product', 1704);
        $product2 = new Product('Test product 2', 417);

        return new Cart(Uuid::v4(), [
            new CartItem($product, 32),
            new CartItem($product2, 4),
        ]);
    }
}
