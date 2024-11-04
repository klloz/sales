<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Sales\Discount\Builder;

use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Cart\CartItem;
use App\Domain\Sales\Discount\Builder\CartCostOver100CartItemDiscountBuilder;
use App\Domain\Sales\Discount\Discount;
use App\Domain\Sales\Product\Product;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CartCostOver100CartItemDiscountBuilderTest extends TestCase
{
    private CartCostOver100CartItemDiscountBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new CartCostOver100CartItemDiscountBuilder();
    }

    /**
     * @dataProvider cartProvider
     */
    public function testApplies(Cart $cartItem, bool $expectedApplies): void
    {
        $this->assertEquals($expectedApplies, $this->builder->applies($cartItem));
    }

    public function testBuild(): void
    {
        $product = new Product('Test product', 1704);
        $cart = new Cart(Uuid::v4(), [new CartItem($product, 32)]);

        $expectedDiscount = new Discount(5453, '10% discount');

        $discount = $this->builder->build($cart);
        $this->assertEquals($expectedDiscount, $discount);
    }

    public function cartProvider(): array
    {
        $product = new Product('Test product', 111);
        $product2 = new Product('Test product 2', 1457);

        return [
            [
                'cartItem' => new Cart(Uuid::v4(), [new CartItem($product, 1)]),
                'expectedApplies' => false,
            ],
            [
                'cartItem' => new Cart(Uuid::v4(), [
                    new CartItem($product, 10),
                    new CartItem($product2, 15),
                ]),
                'expectedApplies' => true,
            ]
        ];
    }
}
