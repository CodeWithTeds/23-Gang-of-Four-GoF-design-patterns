<?php

namespace App\Patterns\Facade;

class Yt
{
    public function parseId(string $url): string
    {
        // Handle short URL: youtu.be/VIDEOID
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $m)) {
            return $m[1];
        }

        // Handle standard watch URL: youtube.com/watch?v=VIDEOID
        if (preg_match('/[?&]v=([a-zA-Z0-9_-]+)/', $url, $m)) {
            return $m[1];
        }

        // Handle embed URL: youtube.com/embed/VIDEOID
        if (preg_match('/embed\/([a-zA-Z0-9_-]+)/', $url, $m)) {
            return $m[1];
        }

        return trim($url);
    }

    public function fetchRaw(string $id, string $format = 'mp4'): string
    {
        $format = strtolower($format);
        $header = sprintf('YOUTUBE_RAW[id=%s, fmt=%s]', $id, $format);
        $body = sprintf('binary-video-content-for-%s...', $id);
        return $header."\n".$body;
    }
}
