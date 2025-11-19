<?php

namespace App\Patterns\Builder;

class LuxuryHouseBuilder implements HouseBuilder
{
    private House $house;

    public function __construct()
    {
        $this->house = new House();
    }

    public function buildFoundation(): void
    {
        $this->house->setFoundation('Deep Reinforced Concrete Foundation with Earthquake Support');
    }

    public function buildStructure(): void
    {
        $this->house->setWalls('Premium Reinforced Steel + Concrete Walls with Soundproof Insulation');
    }

    public function buildRoof(): void
    {
        $this->house->setRoof('High-End Spanish Tile Roofing with Solar Panel Integration');
    }

    public function addGarage(): void
    {
        $this->house->addGarage('Luxury 3-Car Garage with Automated Doors and EV Charging');
    }

    public function addRooms(int $count): void
    {
        $this->house->addRooms($count);
    }

    public function addGarden(): void
    {
        $this->house->addGarden('Landscaped Garden with Water Fountain, Patio, and Outdoor Kitchen');
    }

    public function getHouse(): House
    {
        return $this->house;
    }
}
