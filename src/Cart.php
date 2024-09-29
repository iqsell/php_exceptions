<?php

namespace App;

use App\Exceptions\ItemOutOfStockException;
use App\Exceptions\CartLimitExceededException;

class Cart
{
    private array $items = [];
    private int $maxItems;

    public function __construct(int $maxItems = 20)
    {
        $this->maxItems = $maxItems;
    }

    /**
     * @throws CartLimitExceededException
     * @throws ItemOutOfStockException|Exceptions\OutOfStockException
     */
    public function addItem(Product $product, int $quantity): void
    {
        if (count($this->items) >= $this->maxItems) {
            throw new CartLimitExceededException("Cart limit exceeded.");
        }

        if ($product->getStock() < $quantity) {
            throw new ItemOutOfStockException("Not enough stock for product: 
            " . $product->getName());
        }

        $product->reduceStock($quantity);
        $this->items[] = ['product' => $product, 'quantity' => $quantity];
    }

    public function getTotal(): int
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}
