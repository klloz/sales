<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Repository\Sales\Cart;

use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Cart\CartItem;
use App\Domain\Sales\Cart\CartRepository;
use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Uid\Uuid;

class RedisCartRepositoryTest extends KernelTestCase
{
    private Client $redisClient;

    private CartRepository $cartRepository;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->redisClient = new Client(static::getContainer()->getParameter('app.redis_url'));
        $this->redisClient->flushdb();

        $this->cartRepository = static::getContainer()->get(CartRepository::class);
    }

    protected function tearDown(): void
    {
        $this->redisClient->flushdb();
        parent::tearDown();
    }

    public function testSaveAndGetById(): void
    {
        $cart = new Cart(
            Uuid::v4(),
            [new CartItem(123, 12)]
        );
        $this->cartRepository->save($cart);

        $cartRetrieved = $this->cartRepository->findById($cart->getId());

        self::assertEquals($cart->getId(), $cartRetrieved->getId());
    }

    public function testFindByIdNotFound(): void
    {
        $cart = $this->cartRepository->findById(Uuid::v4());

        self::assertNull($cart);
    }
}
