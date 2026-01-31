<?php

namespace App\Patterns\Memento;

class History
{
    private array $stack = [];
    private array $redo = [];


    public function save(TextMemento $m): void
    {
        $this->stack[] = $m;
        $this->redo = []; //clear redo on new change
    }

    public function redo(): TextMemento
    {
        // if(empty($this->redo)){
        //     return null;
        // }
        $m  = array_pop($this->redo);
        $this->stack[] = $m;
        return $m;
    }

    public function undo(): TextMemento
    {

    }
}
