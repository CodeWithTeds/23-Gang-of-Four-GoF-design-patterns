<?php


namespace App\Patterns\Decorator;


class BasicNotifier implements Notifier
{
    public function send(string $message): string
    {
        return sprintf('APP:', $message);
    }
}
