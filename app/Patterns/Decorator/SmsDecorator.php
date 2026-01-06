<?php

namespace App\Patterns\Decorator;

class SmsDecorator extends NotifierDecorator
{
    public function send(string $message): string
    {
        $base = parent::send($message);
        return $base . "\n".sprintf('SMS:', $message);
    }
}
