<?php

namespace App\Patterns\Prototype;

interface ShapePrototype
{
    public function duplicate(): self;
}
