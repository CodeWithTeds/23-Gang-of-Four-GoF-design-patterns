<?php

namespace App\Patterns\Command;

class Editor
{
    private string $text = '';

    public function append(string $t): void
    {
        $this->text = $t;
    }

    public function set(string $t): void
    {
        $this->text = $t;
    }

    public function deleteLast(int $n): void
    {
        $this->text = substr($this->text, 0, max(0, strlen($this->text) - $n));
    }

    public function get(): string
    {
        return $this->text;
    }
}
