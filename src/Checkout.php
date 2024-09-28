<?php

namespace App;

use App\Exceptions\PaymentGatewayException;
use App\Exceptions\InsufficientFundsException;
class Checkout {
    private $cart;
    private $paymentMethod;

    public function __construct(Cart $cart) {
        $this->cart = $cart;
    }

    public function setPaymentMethod($method) {
        $this->paymentMethod = $method;
    }

    /**
     * @throws PaymentGatewayException
     * @throws InsufficientFundsException
     */
    public function processPayment($amount) {
        // Например, процесс оплаты
        if ($amount > 1000) {
            throw new PaymentGatewayException("Payment gateway failed.");
        }

        $userBalance = 500;
        if ($amount > $userBalance) {
            throw new InsufficientFundsException("Insufficient funds.");
        }
    }

    public function finalizeOrder() {
        $total = $this->cart->getTotal();
        try {
            $this->processPayment($total);
            echo "Payment of $total processed successfully using " . $this->paymentMethod . ".\n";
        } catch (PaymentGatewayException $e) {
            echo "Payment failed: " . $e->getMessage() . "\n";
        } catch (InsufficientFundsException $e) {
            echo "Payment failed: " . $e->getMessage() . "\n";
        }
    }
}
