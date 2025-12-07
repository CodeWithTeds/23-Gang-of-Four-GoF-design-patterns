<?php

namespace App\Patterns\Composite;


interface OrderComponent
{
    public function getName(): string;

    public function getTotal(): float;

    public function describe(int $indent = 0): string;
}
