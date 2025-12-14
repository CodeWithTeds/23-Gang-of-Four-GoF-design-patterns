<?php

namespace App\Patterns\Facade;

class YTDownloaderFacade
{
    public function __construct
    (
        private YT $yt,
        private FFMpeg $ffmpeg,
        private FileStorage $storage,
    ) {}

    public function download(string $url, string $format = 'mp4'): array
    {
        $id = $this->yt->parseId($url);
        $raw = $this->yt->fetchRaw($id, $format);

        $video = $this->ffmpeg->open($raw);
        $content = $video->encode($format);

        $filename = $id.'.'.strtolower($format);
        $path = $this->storage->save($filename, $content);

        return [
            'path' => $path,
            'filename' => $filename,
            'id' => $id,
            'format' => strtolower($format),
        ];
    }
}
