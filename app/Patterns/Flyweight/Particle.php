<?php

namespace App\Patterns\Flyweight;


class Particle
{
    protected ParticleType $type;
    protected int $x;
    protected int $y;
    protected int $lifetime;

    public function __construct(ParticleType $type, int $x, int $y, int $lifetime)
    {
        $this->type = $type;
        $this->x = $x;
        $this->y = $y;
        $this->lifetime = $lifetime;
    }

    public function update(int $dt): void
    {
        $this->lifetime -= $dt;
    }

    public function isAlive(): bool
    {
        return $this->lifetime > 0;
    }

    public function draw(): string
    {
        return $this->type->render($this->x, $this->y);
    }


}
