<?php

namespace App;

use App\Exceptions\PaymentGatewayException;
use App\Exceptions\InsufficientFundsException;

class Checkout
{
    private Cart $cart;
    private string $paymentMethod;
    private int $userBalance;

    public function __construct(Cart $cart, int $userBalance)
    {
        $this->cart = $cart;
        $this->userBalance = $userBalance;
    }

    public function setPaymentMethod(string $method): void
    {
        $this->paymentMethod = $method;
    }

    /**
     * Обработка платежа.
     *
     * @param  int $amount Сумма платежа.
     * @throws PaymentGatewayException Если произошла ошибка при оплате.
     * @throws InsufficientFundsException Если на счете недостаточно средств.
     */
    public function processPayment(int $amount): void
    {
        if ($amount > $this->userBalance) {
            throw new InsufficientFundsException("Недостаточно средств.");
        }

        // Симуляция платежного процесса
        if ($this->paymentMethod !== 'credit card') {
            throw new PaymentGatewayException("Ошибка платежного шлюза.");
        }

        // Успешный платеж
        $this->userBalance -= $amount;
        echo "Платеж на сумму $amount успешно обработан с использованием метода $this->paymentMethod.\n";
    }


    public function finalizeOrder(): void
    {
        $totalAmount = $this->cart->getTotal(); // Получение общей суммы корзины
        try {
            $this->processPayment($totalAmount);
        } catch (InsufficientFundsException | PaymentGatewayException $e) {
            echo "Ошибка при оплате: " . $e->getMessage();
        }
    }
}
