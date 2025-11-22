<?php

namespace App\Patterns\Prototype;

class Rectangle extends Shape
{
    private int $width = 100;
    private int $height = 50;


    public function setSize(int $width, int $height): void
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function describe(): string
    {
        return sprintf(
            'Rectangle %dx%d at (%d, %d) style=[fill=%s, stroke=%d]',
            $this->width,
            $this->height,
            $this->x,
            $this->y,
            $this->style->fillColor,
            $this->style->strokeWidth
        );
    }
}
