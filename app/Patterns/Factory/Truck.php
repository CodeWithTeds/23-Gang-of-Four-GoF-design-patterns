<?php

namespace App\Patterns\Factory;
/**
 * Concrete Products: Truck
 *
 */
class Truck implements Transport{

    public function deliver(): string
    {
        return 'Delivering by truck (RoadLogistics)';
    }


}
