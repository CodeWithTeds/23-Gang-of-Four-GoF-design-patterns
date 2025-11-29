<?php

namespace App\Patterns\Adapter;

class RoundPeg implements RoundPegInterface
{
    private float $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function getRadius(): float
    {
        return $this->radius;
    }

    public function describe(): string
    {
        return sprintf('RoundPeg  radius=%.2f', $this->radius);
    }
}
