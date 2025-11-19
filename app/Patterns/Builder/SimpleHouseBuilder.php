<?php

namespace App\Patterns\Builder;

class SimpleHouseBuilder implements HouseBuilder
{
    private House $house;

    public function __construct()
    {
        $this->house = new House();
    }


    public function buildFoundation(): void
    {
        $this->house->setFoundation('Standard Concrete Foundation');
    }

    public function buildStructure(): void
    {
        $this->house->setWalls('Basic Wooden Wall Frame');
    }

    public function buildRoof(): void
    {
        $this->house->setRoof('Asphalt Shingle Roofing');
    }

    public function addGarage(): void
    {
        $this->house->addGarage('Single-Car Attached Garage');
    }

    public function addRooms(int $count): void
    {
        $this->house->addRooms($count);
    }

    public function addGarden(): void
    {
        $this->house->addGarden('Small Front Garden with Grass and Plants');
    }

    public function getHouse(): House
    {
        return $this->house;
    }
}
