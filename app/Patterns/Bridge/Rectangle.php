<?php

namespace App\Patterns\Bridge;

use Symfony\Component\CssSelector\Node\FunctionNode;

class Rectangle extends Shape
{
    private int $width = 100;
    private int $height = 50;


    public function setSize(int $width, int $height): void
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function draw(): string
    {
        return sprintf('Rectangle %dx%d color=%s', $this->width, $this->height, $this->color->apply());
    }
}
