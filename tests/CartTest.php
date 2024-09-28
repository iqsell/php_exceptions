<?php

use PHPUnit\Framework\TestCase;
use App\Cart;
use App\Product;
use App\Exceptions\ItemOutOfStockException;
use App\Exceptions\CartLimitExceededException;

class CartTest extends TestCase {
    public function testAddItemToCart() {
        $product = new Product("T-shirt", 100, 10);
        $cart = new Cart();
        $cart->addItem($product, 2);
        $this->assertEquals(8, $product->getStock());
    }

    public function testItemOutOfStockException() {
        $this->expectException(ItemOutOfStockException::class);
        $product = new Product("T-shirt", 100, 1);
        $cart = new Cart();
        $cart->addItem($product, 2);
    }

    public function testCartLimitExceededException() {
        $this->expectException(CartLimitExceededException::class);
        $cart = new Cart(1); // Ограничим корзину до 1 товара
        $product1 = new Product("T-shirt", 100, 10);
        $product2 = new Product("Jeans", 200, 5);
        $cart->addItem($product1, 1);
        $cart->addItem($product2, 1); // исключение
    }
}
