<?php

declare(strict_types=1);

namespace App\Domain\Sales\Product;

use App\Infrastructure\Repository\Sales\Product\DoctrineProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    public function __construct(
        #[ORM\Column]
        private string $name,
        #[ORM\Column(type: 'integer')]
        private int $cost
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCost(): int
    {
        return $this->cost;
    }
}
