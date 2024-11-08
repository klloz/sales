<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Sales\Product;

use App\Domain\Sales\Product\Product;
use App\Domain\Sales\Product\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product): void
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    public function findById(int $id): ?Product
    {
        return $this->find($id);
    }
}
