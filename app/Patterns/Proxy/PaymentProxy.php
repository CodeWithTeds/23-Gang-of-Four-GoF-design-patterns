<?php

namespace App\Patterns\Proxy;

class PaymentProxy implements PaymentGateway
{
    private ?PaymentGateway $real = null;
    private array $limits = [];
    private float $maxPerToken = 500.0;
    private array $allowed = ['USD', 'EUR', 'GBP'];

    public function __construct(?PaymentGateway $real = null)
    {
        $this->real = $real;
    }


    public function charge(float $amount, string $currency, string $token): string
    {
        if($amount <= 0){
            return 'BLOCK:invalid_amount';
        }

        $cur = strtoupper($currency);
        if(!in_array($cur, $this->allowed, true)){
            return 'BLOCK:currency_not_allowed';
        }

        if(strpos($token, 'tok_') !== 0){
            return 'BLOCK:invalid_token';
        }

        $used = $this->limits[$token] ?? 0.0;
        if($used + $amount > $this->maxPerToken){
            return 'BLOCK:limit_exceeded';
        }

        $this->limits[$token] = $used + $amount;
        if ($this->real === null){
            $this->real = new RealPaymentGateway();
        }

        return $this->real->charge($amount, $cur, $token);
    }
}
