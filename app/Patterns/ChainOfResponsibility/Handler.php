<?php

namespace App\Patterns\ChainOfResponsibility;

abstract class Handler
{
    private ?Handler $next = null;

    public function setNext(Handler $next): Handler
    {
        $this->next = $next;
        return $next;
    }


    public function pass(Request $req): string
    {
        if ($this->next) {
            return $this->next->handle($req);
        }

        return 'OK';
    }

    abstract public function handle(Request $req): string;
}
