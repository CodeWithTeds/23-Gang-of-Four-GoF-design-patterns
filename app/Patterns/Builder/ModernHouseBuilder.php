<?php


namespace App\Patterns\Builder;

class ModernHouseBuilder implements HouseBuilder
{
    private House $house;

    public function __construct()
    {
        $this->house = new House();
    }

    public function buildFoundation(): void
    {
        $this->house->setFoundation('Advanced Reinforced Steel Foundation');
    }

    public function buildStructure(): void
    {
        $this->house->setWalls('Glass + Steel Frame Modern Architecture');
    }

    public function buildRoof(): void
    {
        $this->house->setRoof('Flat Concrete Roof with Skylights');
    }

    public function addGarage(): void
    {
        $this->house->addGarage('2-Car Garage w/ Glass Door and EV Charging');
    }

    public function addRooms(int $count): void
    {
        $this->house->addRooms($count);
    }

    public function addGarden(): void
    {
        $this->house->addGarden('Minimalist Garden with Waterfall and Bamboo');
    }

    public function getHouse(): House
    {
        return $this->house;
    }
}

