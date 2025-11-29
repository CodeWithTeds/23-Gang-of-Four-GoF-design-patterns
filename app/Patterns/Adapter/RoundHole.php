<?php


namespace App\Patterns\Adapter;

class RoundHole
{
    private float $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function fits(RoundPegInterface $peg): bool
    {
        return $this->radius >= $peg->getRadius();
    }

    public function getRadius(): float
    {
        return $this->radius;
    }

    public function describe(): string
    {
        return sprintf('RoundHole  radius=%.2f', $this->radius);
    }
}
