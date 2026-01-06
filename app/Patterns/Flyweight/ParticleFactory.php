<?php


namespace App\Patterns\Flyweight;

class ParticleFactory
{
    private array $types = [];

    public function getType(string $name, string $texture, string $color, int $size): ParticleType
    {
        $key = strtolower($name . '_' . $texture . '_' . $color . '_' . $size);
        if(!isset($this->types[$key])) {
            $this->types[$key] = new ParticleType($name, $texture, $color, $size);
            }
        return $this->types[$key];
    }


    public function count(): int
    {
        return count($this->types);
    }

}
