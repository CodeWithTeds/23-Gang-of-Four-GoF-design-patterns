<?php

namespace App\Patterns\Decorator;


interface Notifier
{
    public function send(string $message): string;

}
