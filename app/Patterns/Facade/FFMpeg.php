<?php

namespace App\Patterns\Facade;

class FFMpeg
{
    public function open(string $raw): FFMpegVideo
    {
        return new FFMpegVideo($raw);
    }
}
