<?php

use PHPUnit\Framework\TestCase;
use App\Product;


class ProductTest extends TestCase {
    public function testReduceStock() {
        $product = new Product("T-shirt", 100, 10);
        $product->reduceStock(2);
        $this->assertEquals(8, $product->getStock());
    }

}
