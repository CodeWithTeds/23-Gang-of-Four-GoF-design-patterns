<?php

namespace App\Patterns\Adapter;

class SquarePegAdapter implements RoundPegInterface
{
    private SquarePeg $squarePeg;

    public function __construct(SquarePeg $squarePeg)
    {
        $this->squarePeg = $squarePeg;
    }

    public function getRadius(): float
    {
        return $this->squarePeg->getWidth() * sqrt(2) / 2.0;
    }

    public function describe(): string
    {
        return sprintf(
            'SquarePegAdapter effectiveRadius=%.2f',
            $this->getRadius(),
            $this->squarePeg->getWidth()
        );
    }
}
