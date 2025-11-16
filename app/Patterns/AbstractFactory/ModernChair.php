<?php

namespace App\Patterns\AbstractFactory;


class ModernChair implements Chair
{
    public function sit(): string
    {
        return 'Sitting on a modern chair';
    }
}
