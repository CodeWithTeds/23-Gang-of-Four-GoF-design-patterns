<?php

namespace App\Patterns\Command;

interface Command
{
    public function execute(): string;
    public function undo(): string;
}

