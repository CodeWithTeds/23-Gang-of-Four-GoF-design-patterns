<?php

namespace App\Patterns\Proxy;


interface PaymentGateway
{
    public function charge(float $amount, string $currency, string $token): string;
}
