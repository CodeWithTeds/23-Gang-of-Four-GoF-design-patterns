<?php

namespace App\Patterns\Singleton;

/**
 * Creational Design pattern
 * let you insure that a class
 * has only one instance
 *
 */
class Logger
{
    private static ?Logger $instance = null;

    private array $logs = [];

    private string $id;

    private function __construct()
    {
        // Unique logger ID so you know this logger instance is reused
        $this->id = bin2hex(random_bytes(4));
    }

    public static function getInstance(): self
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function log(string $message): void
    {
        $this->logs[] = $message;
    }

    public function getLogs(): array
    {
        return $this->logs;
    }

    public function getId(): string
    {
        return $this->id;
    }


}
