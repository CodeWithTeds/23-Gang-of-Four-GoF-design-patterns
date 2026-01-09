<?php

namespace App\Patterns\ChainOfResponsibility;

class ControllerHandler extends Handler
{
    public function handle(Request $req): string
    {
        return 'OK:action_'.$req->action;
    }
}
