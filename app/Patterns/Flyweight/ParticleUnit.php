<?php

namespace App\Patterns\Flyweight;

class ParticleUnit
{
    private ParticleFactory $factory;
    private array $particles = [];

    public function __construct(ParticleFactory $factory)
    {
        $this->factory = $factory;
    }

    public function spawn(string $name, string $texture, string $color, int $size, int $count): void
    {
        $type = $this->factory->getType($name, $texture, $color, $size);
        for ($i = 0; $i < $count; $i++){
            $x = mt_rand(0, 1000);
            $y = mt_rand(0, 1000);
            $lifetime = mt_rand(3, 10);
            $vx = mt_rand(-5, 5) / 1.0;
            $vy = mt_rand(-5, 5) / 1.0;

            $this->particles[] = new MovingParticle($type, $x, $y, $lifetime, $vx, $vy);
        }
    }

    public function step(int $dt)
    {
        foreach ($this->particles as $p){
            $p->update($dt);
        }

        $this->particles = array_values(array_filter($this->particles, fn($p) => $p->isAlive()));
    }

    public function renderSample(int $limit = 5): string
    {
        $out = [];
        $n = min($limit, count($this->particles));
        for ($i = 0; $i < $n; $i++){
            $out[] = $this->particles[$i]->draw();
        }
        return implode("\n", $out);
    }

    public function count(): int
    {
        return count($this->particles);
    }
}
