<?php

declare(strict_types=1);

namespace App\Tests\Integration\Domain\Sales\Cart\Calculator;

use App\Domain\Sales\Cart\Calculator\CostCalculator;
use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Cart\CartItem;
use App\Domain\Sales\Cart\Cost;
use App\Domain\Sales\Discount\Discount;
use App\Domain\Sales\Discount\DiscountsProvider;
use App\Domain\Sales\Product\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class CostCalculatorTest extends KernelTestCase
{
    public function testCalculateCost(): void
    {
        $cart = $this->prepareCart();
        $discounts = [new Discount(11000, '10% discount')];

        $discountProvider = $this->createMock(DiscountsProvider::class);
        $discountProvider->expects($this->once())
            ->method('provide')
            ->with($cart)
            ->willReturn($discounts);

        static::getContainer()->set(DiscountsProvider::class, $discountProvider);

        $expectedCost = new Cost(56196, $discounts);

        $cost = (new CostCalculator($discountProvider))->calculateCost($cart);
        $this->assertEquals($expectedCost, $cost);
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
