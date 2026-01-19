<?php

namespace App\Patterns\Iterator;

interface ProfileIterator
{
    public function hasNext(): bool;
    public function reset(): void;
    public function next(): ?Profile;
}
