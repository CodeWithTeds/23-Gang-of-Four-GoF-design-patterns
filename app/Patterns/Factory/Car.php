<?php

namespace App\Patterns\Factory;


class Car implements Transport
{
    public function deliver(): string
    {
        return 'Delivering by Car (RoadLogistics)';
    }
}

