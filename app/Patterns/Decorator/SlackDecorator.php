<?php

namespace App\Patterns\Decorator;

class Slack extends NotifierDecorator
{
    public function send(string $message): string
    {
        $base = parent::send($message);
        return $base . "\n".sprintf('Slack:', $message);
    }

}
