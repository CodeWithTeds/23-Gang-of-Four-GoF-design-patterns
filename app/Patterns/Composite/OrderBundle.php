<?php

namespace App\Patterns\Composite;

class OrderBundle implements OrderComponent
{
    private array $children = [];
    private float $discountPercent = 0.0;

    public function __construct(private string $name) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function add(OrderComponent $component): void
    {
        $this->children[] = $component;
    }

    public function remove(OrderComponent $component): void
    {
        foreach ($this->children as $i => $child) {
            if ($child === $component) {
                unset($this->children[$i]);
                $this->children = array_values($this->children);
                break;
            }
        };
    }


    public function setDiscountPercent(float $percent): void
    {
        $this->discountPercent = max(0.0, $percent);
    }

    public function getDiscountPercent(float $percent): float
    {
        return $this->discountPercent;
    }


    public function getTotal(): float
    {
        $sum = 0.0;

        foreach ($this->children as $child) {
            $sum += $child->getTotal();
        }
        if ($this->discountPercent > 0) {
            $sum = $sum * (1 - ($this->discountPercent / 100));
        }

        return $sum;
    }

    public function describe(int $indent = 0): string
    {
        $space = str_repeat(' ', $indent);

        $description = "{$space}Bundle: {$this->name}";

        if ($this->discountPercent > 0) {
            $description .= " (Discount: {$this->discountPercent}%)";
        }

        $description .= PHP_EOL;

        foreach ($this->children as $child) {
            $description .= $child->describe($indent + 2);
        }

        return $description;
    }

}
