<?php

namespace App\Patterns\Facade;

class FileStorage
{
    private string $baseDir;

    public function __construct(?string $baseDir = null)
    {
        $this->baseDir = $baseDir ?? \storage_path('app/facade_downloads');
        if (!is_dir($this->baseDir)) {
            mkdir($this->baseDir, 0777, true);
        }
    }


    public function save(string $filename, string $content): string
    {
        $path = rtrim($this->baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
        file_put_contents($path, $content);

        return $path;
    }
}
