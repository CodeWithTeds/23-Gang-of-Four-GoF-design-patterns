<?php

namespace App\Patterns\Mediator;

interface ChatMediator
{
    public function send(string $message, User $from, ?User $to = null): array;
    public function register(User $user): void;
}
