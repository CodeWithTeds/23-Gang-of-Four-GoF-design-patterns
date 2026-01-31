<?php

namespace App\Patterns\Mediator;

class User{

    private string $id;
    private string $name;
    private ChatMediator $mediator;

    public function __construct(string $id, string $name, ChatMediator $mediator)
    {
        $this->id = $id;
        $this->name = $name;
        $this->mediator = $mediator;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function say( string $message): array {
        return $this->mediator->send($message, $this);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function receive(User $from, string $message): string
    {
        return $this->name. '<-'.$from->getName().': '.$message;
    }

    public function whisper(User $to, string $message): array
    {
        return $this->mediator->send($message, $this, $to);
    }
}
