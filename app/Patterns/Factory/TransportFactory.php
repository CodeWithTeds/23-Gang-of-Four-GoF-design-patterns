<?php

namespace App\Patterns\Factory;

use InvalidArgumentException;

/**
 * The Creator class declares the factory method that returns new product objects.
 */
class TransportFactory
{
    public static function create(string $type): Transport
    {
        return match(strtolower($type)){
            'bike' => new Bike(),
            'truck' => new Truck(),
            'ship' => new Ship(),
            'car' => new Car(),
             'default' => throw new InvalidArgumentException("Uknown transport type"),
        };
    }
}
