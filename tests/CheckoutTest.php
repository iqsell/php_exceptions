<?php

use PHPUnit\Framework\TestCase;
use App\Checkout;
use App\Cart;
use App\Product;


class CheckoutTest extends TestCase {
    public function testProcessPayment() {
        $product = new Product("T-shirt", 100, 10);
        $cart = new Cart();
        $cart->addItem($product, 2);

        $checkout = new Checkout($cart);
        $checkout->setPaymentMethod("credit card");

        // оплата должна пройти.
        $this->expectNotToPerformAssertions();
        $checkout->finalizeOrder();
    }

}
