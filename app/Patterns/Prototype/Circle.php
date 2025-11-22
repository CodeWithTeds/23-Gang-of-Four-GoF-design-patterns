<?php

namespace App\Patterns\Prototype;

class Circle extends Shape
{
    private int $radius = 50;

    public function setRadius(int $radius): void
    {
        $this->radius = $radius;
    }

    public function describe(): string
    {
        return sprintf(
            'Circle r=%d at (%d, %d) style=[fill=%s, stroke=%d]',
            $this->radius,
            $this->x,
            $this->y,
            $this->style->fillColor,
            $this->style->strokeWidth
        );
    }
}
