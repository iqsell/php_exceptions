<?php

namespace App;

use App\Exceptions\ItemOutOfStockException;
use App\Exceptions\CartLimitExceededException;

class Cart {
    private $items = [];
    private $maxItems;

    public function __construct($maxItems = 20) {
        $this->maxItems = $maxItems;
    }

    /**
     * @throws CartLimitExceededException
     * @throws ItemOutOfStockException
     */
    public function addItem(Product $product, $quantity) {
        if (count($this->items) >= $this->maxItems) {
            throw new CartLimitExceededException("Cart limit exceeded.");
        }

        if ($product->getStock() < $quantity) {
            throw new ItemOutOfStockException("Not enough stock for product: " . $product->getName());
        }

        $product->reduceStock($quantity);
        $this->items[] = ['product' => $product, 'quantity' => $quantity];
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}
