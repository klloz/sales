<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Repository\Sales\Product;

use App\Domain\Sales\Product\Product;
use App\Domain\Sales\Product\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineProductRepositoryTest extends KernelTestCase
{
    private ProductRepository $productRepository;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->productRepository = self::getContainer()->get(ProductRepository::class);
    }

    public function testSaveAndGetById(): void
    {
        $product = new Product('Test product', 123456);
        $this->productRepository->save($product);

        $productRetrieved = $this->productRepository->findById($product->getId());

        self::assertEquals($product->getId(), $productRetrieved->getId());
    }

    public function testFindByIdNotFound(): void
    {
        $cart = $this->productRepository->findById(999);

        self::assertNull($cart);
    }
}
