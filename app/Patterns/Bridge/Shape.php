<?php

namespace App\Patterns\Bridge;

abstract class Shape
{
    protected Color $color;

    public function __construct(Color $color)
    {
        $this->color = $color;
    }

    abstract public function draw(): string;
}
