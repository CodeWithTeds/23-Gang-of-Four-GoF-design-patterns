<?php

namespace App\Patterns\Flyweight;

class MovingParticle extends Particle
{

    /**
     * you store it once and let everyone share it.
     */
    private float $vx;
    private float $vy;

    public function __construct(
        ParticleType $type, int $x, int $y, int $lifetime, float $vx, float $vy)
    {
        parent::__construct($type, $x, $y, $lifetime);
        $this->vx = $vx;
        $this->vy = $vy;
    }

    public function update(int $dt): void
    {
        $this->x += (int) round($this->vx * $dt);
        $this->y += (int) round($this->vy * $dt);
        parent::update($dt);
    }

}

