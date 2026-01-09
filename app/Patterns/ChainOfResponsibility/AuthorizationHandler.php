<?php

namespace App\Patterns\ChainOfResponsibility;

class AuthorizationHandler extends Handler
{
    public function handle(Request $req): string
    {
        $roles = array_map('strtolower', $req->roles);
        $action = strtolower($req->action);

        $ok = match ($action){
            'read' => in_array('user', $roles, true) || in_array('editor', $roles, true) || in_array('admin', $roles, true),
            'write' => in_array('editor', $roles, true) || in_array('admin', $roles, true),
            'delete' => in_array('admin', $roles, true),
            'default' => false,
        };

        if (!$ok){
            return 'DENY:authorization_failed';
        }

        return $this->pass($req);

    }
}
