<?php

namespace App\Patterns\AbstractFactory;

class ArtDecoSofa implements Sofa
{
    public function lounge(): string
    {
        return 'Loungin on a ArtDeco Chair';
    }
}
