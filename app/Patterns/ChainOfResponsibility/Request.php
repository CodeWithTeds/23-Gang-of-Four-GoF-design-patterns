<?php

namespace App\Patterns\ChainOfResponsibility;

class Request
{
    public string $token;
    public array $roles;
    public string $action;

    public function __construct(string $token, array $roles, string $action)
    {
        $this->token = $token;
        $this->roles = $roles;
        $this->action = $action;
    }

    // public function __construct(string $token, array $roles, string $action)
    // {

    // }
}
