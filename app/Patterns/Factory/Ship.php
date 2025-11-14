<?php

namespace App\Patterns\Factory;


class Ship implements Transport
{
    public function deliver(): string
    {
        return 'Delivering by Ship (SeaLogistics)';
    }
}

