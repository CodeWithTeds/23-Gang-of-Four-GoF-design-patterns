<?php

namespace App\Patterns\Decorator;

class FacebookDecorator extends NotifierDecorator
{
    public function send(string $message): string
    {
        $base = parent::send($message);
        return $base . "\n".sprintf('Facebook:', $message);
    }

}
