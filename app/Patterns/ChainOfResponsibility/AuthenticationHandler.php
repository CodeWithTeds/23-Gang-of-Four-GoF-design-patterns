<?php

namespace App\Patterns\ChainOfResponsibility;

class AuthenticationHandler extends Handler
{
    public function handle(Request $req): string
    {
        if (strpos($req->token, 'tok_') !==0){
            return 'DENY::authentication_failed';
        }

        return $this->pass($req);
    }
}
