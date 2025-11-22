<?php

namespace App\Patterns\Prototype;

class Style
{
    public string $fillColor;
    public int $strokeWidth;

    public function __construct(string $fillColor = 'red', int $strokeWidth = 10)
    {
        $this->fillColor = $fillColor;
        $this->strokeWidth = $strokeWidth;
    }
}
