<?php

namespace App\Patterns\Proxy;

class RealPaymentGateway implements PaymentGateway
{
    public function charge(float $amount, string $currency, string $token): string
    {
        $tx = 'tx_'.bin2hex(random_bytes(4));
        return sprintf(
            'OK:%s %.2f %s %s', $tx, $amount, strtoupper($currency), $token
        );

    }
}
