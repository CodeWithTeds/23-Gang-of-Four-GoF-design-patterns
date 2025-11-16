<?php

namespace App\Patterns\AbstractFactory;

class VictorianChair implements Chair
{
    public function sit(): string
    {
        return 'Sitting on a Victorian Chair';
    }
}
