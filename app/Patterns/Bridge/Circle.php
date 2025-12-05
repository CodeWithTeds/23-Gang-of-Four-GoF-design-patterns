<?php


namespace App\Patterns\Bridge;

class Circle extends Shape
{
    private int $radius = 50;

    public function setRadius(int $radius): void
    {
        $this->radius = $radius;
    }

    public function draw():string
    {
        return sprintf('Circle radius=%d color=%s', $this->radius, $this->color->apply());
    }
}
