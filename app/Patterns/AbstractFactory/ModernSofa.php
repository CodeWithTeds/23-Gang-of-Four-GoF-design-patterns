<?php

namespace App\Patterns\AbstractFactory;

class ModernSofa implements Sofa
{
    public function lounge(): string
    {
        Return 'Lounging on a Modern Sofa';
    }
}
