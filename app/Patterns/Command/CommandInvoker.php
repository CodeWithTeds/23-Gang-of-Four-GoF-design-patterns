<?php

namespace App\Patterns\Command;

class CommandInvoker
{
    private array $history = [];

    public function run(Command $command): string
    {
        $result = $command->execute();
        $this->history[] = $command;
        return $result;
    }

    public function undo(int $count = 1): array
    {
        $states = [];

        for ($i = 0; $i < $count && !empty($this->history); $i++) {
            $command = array_pop($this->history);
            $states[] = $command->undo();
        }

        return $states;
    }
}
