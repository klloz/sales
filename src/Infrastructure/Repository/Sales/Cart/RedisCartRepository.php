<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Sales\Cart;

use App\Domain\Sales\Cart\Cart;
use App\Domain\Sales\Cart\CartRepository;
use App\Domain\Sales\Cart\Serializer\CartNormalizer;
use Predis\Client;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

class RedisCartRepository implements CartRepository
{
    private const REDIS_KEY_PATTERN = 'cart:%s';

    private const EXPIRE_TTL = 60 * 60 * 24;

    public function __construct(
        private readonly Client $redisClient,
        private readonly CartNormalizer $cartNormalizer,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function save(Cart $cart): void
    {
        $this->redisClient->set(
            self::redisKey($cart->getId()),
            $this->serializer->serialize($this->cartNormalizer->normalize($cart), 'json'),
            'EX',
            self::EXPIRE_TTL
        );
    }

    public function findById(Uuid $id): ?Cart
    {
        if ($cart = $this->redisClient->get(self::redisKey($id))) {
            return $this->cartNormalizer->denormalize(\json_decode($cart, true));
        }

        return null;
    }

    private static function redisKey(Uuid $id): string
    {
        return \sprintf(self::REDIS_KEY_PATTERN, $id);
    }
}
