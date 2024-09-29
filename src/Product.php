<?php

namespace App;

use App\Exceptions\OutOfStockException;

class Product
{
    protected string $name;
    protected float $price;
    protected int $stock;

    public function __construct(string $name, float $price, int $stock)
    {
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * Уменьшает количество товара на складе.
     *
     * @param  int $quantity Количество для уменьшения.
     * @throws OutOfStockException Если недостаточно товара на складе.
     */
    public function reduceStock(int $quantity): void
    {
        if ($this->stock < $quantity) {
            throw new OutOfStockException("Недостаточно товара на складе для продукта: " . $this->name);
        }
        $this->stock -= $quantity;
    }
}
