<?php

namespace App\Patterns\Prototype;

abstract class Shape implements ShapePrototype
{
    protected int $x = 0;
    protected int $y = 0;
    protected Style $style;

    public function __construct()
    {
        $this->style = new Style();
    }

    public function __clone(){
        $this->style = clone $this->style;
    }

    public function setPosition(int $x, int $y): void
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function duplicate(): Self
    {
        return clone $this;
    }


    public function setStyle(string $fillColor, int $strokeWidth): void
    {
        $this->style->fillColor = $fillColor;
        $this->style->strokeWidth = $strokeWidth;
    }

    abstract function describe(): string;
}
