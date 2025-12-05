<?php

namespace App\Patterns\Bridge;

class Red implements Color
{
    public function apply(): string
    {
        return 'Red';
    }
}
