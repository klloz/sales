<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Sales\Discount\Builder;

use App\Domain\Sales\Cart\CartItem;
use App\Domain\Sales\Discount\Builder\FifthItemOfSameTypeCartItemDiscountBuilder;
use App\Domain\Sales\Discount\Discount;
use App\Domain\Sales\Product\Product;
use PHPUnit\Framework\TestCase;

class FifthItemOfSameTypeCartItemDiscountBuilderTest extends TestCase
{
    private FifthItemOfSameTypeCartItemDiscountBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new FifthItemOfSameTypeCartItemDiscountBuilder();
    }

    /**
     * @dataProvider cartItemProvider
     */
    public function testApplies(CartItem $cartItem, bool $expectedApplies): void
    {
        $this->assertEquals($expectedApplies, $this->builder->applies($cartItem));
    }

    public function testBuild(): void
    {
        $product = new Product('Test product', 111);
        $cartItem = new CartItem($product, 17);

        $expectedDiscount = new Discount(
            333,
            '(3x) Each fifth item is for free',
            $product
        );

        $discount = $this->builder->build($cartItem);
        $this->assertEquals($expectedDiscount, $discount);
    }

    public function cartItemProvider(): array
    {
        $product = new Product('Test product', 111);

        return [
            [
                'cartItem' => new CartItem($product, 1),
                'expectedApplies' => false,
            ],
            [
                'cartItem' => new CartItem($product, 12),
                'expectedApplies' => true,
            ]
        ];
    }
}
