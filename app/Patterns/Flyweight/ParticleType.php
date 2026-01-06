<?php

namespace App\Patterns\Flyweight;


class ParticleType
{
    public function __construct(
        private string $name,
        private string $texture,
        private string $color,
        private int $size
    ){}

    public function getName(): string
    {
        return $this->name;
    }

    public function render(int $x, int $y): string
    {
        return sprintf(
                "Rendering %s at (%d, %d) with texture '%s', color '%s', size %d",
                $this->name,
                $x,
                $y,
                $this->texture,
                $this->color,
                $this->size
            );
    }

}
