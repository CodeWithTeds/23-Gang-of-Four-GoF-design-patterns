<?php

namespace App\Patterns\Composite;


class OrderItem implements OrderComponent
{
    public function __construct(
        private string $name,
        private float $unitPrice,
        private int $quantity = 1,
    ){}

    public function getName(): string
    {
        return $this->name;
    }

    public function getTotal(): float
    {
        return $this->unitPrice * $this->quantity;
    }

    public function describe(int $indent = 0): string
    {
        // create indentation (2 spaces per level)
        $prefix = str_repeat("  ", $indent);

        return sprintf(
            "%s- %s (Qty: %d, Unit: %.2f, Total: %.2f)",
            $prefix,
            $this->name,
            $this->quantity,
            $this->unitPrice,
            $this->getTotal()
        );
    }
}
