<?php

namespace App\Patterns\Decorator;

/**
 * Decorator is a structural design pattern that lets you attach new behaviors to objects
 * by placing these objects inside special wrapper objects that contain the behaviors.
 */
abstract class NotifierDecorator implements Notifier
{
    public function __construct(protected Notifier $wrappee)
    {
    }

    public function send(string $message): string
    {
        return $this->wrappee->send($message);
    }

}
