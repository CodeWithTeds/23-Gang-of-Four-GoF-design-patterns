<?php

namespace App\Patterns\AbstractFactory;

class ArtDecoChair implements Chair
{
    public function sit(): string
    {
        return 'Sitting on a ArtDeco Chair';
    }
}
