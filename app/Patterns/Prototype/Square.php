<?php

namespace App\Patterns\Prototype;

class Square extends Shape
{
    private int $size = 50; // default size

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function describe(): string
    {
        return sprintf(
            'Square %dx%d at (%d, %d) style=[fill=%s, stroke=%d]',
            $this->size,
            $this->size,
            $this->x,
            $this->y,
            $this->style->fillColor,
            $this->style->strokeWidth
        );
    }
}
