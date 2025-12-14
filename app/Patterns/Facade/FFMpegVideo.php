<?php

namespace App\Patterns\Facade;

class FFMpegVideo
{
    public function __construct(private string $raw)
    {}

    public function encode(string $format): string
    {
        $format = strtolower($format);
        $meta = printf('FFMPEG_ENCODE[%s]', $format);
        return $this->raw."\n".$meta;
    }
}
