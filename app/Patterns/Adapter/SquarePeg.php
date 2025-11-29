<?php

namespace App\Patterns\Adapter;


class SquarePeg
{
    private float $width;

    public function __construct(float $width)
    {
        $this->width = $width;
    }

    public function getWidth(): float
    {
        return $this->width;
    }

    public function describe(): string
    {
        return sprintf('SquarePeg width=%.2f', $this->width);
    }
}
