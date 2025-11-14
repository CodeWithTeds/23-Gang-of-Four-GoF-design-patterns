<?php

namespace App\Patterns\Factory;

/**
 * Factory is a creational design pattern
 * create interface for a object in a superclass
 * can avoid DRY
 */
interface Transport{

    public function deliver(): string;
}

