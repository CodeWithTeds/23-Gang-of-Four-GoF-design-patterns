<?php

namespace App\Patterns\Factory;


class Bike implements Transport
{
    public function deliver(): string
    {
        return 'Delivering by Bike (RoadLogistics)';
    }
}

