<?php


namespace App\Patterns\Bridge;

class Green implements Color
{
    public function apply(): string
    {
        return 'Green';
    }
}
