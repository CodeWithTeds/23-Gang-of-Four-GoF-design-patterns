<?php

namespace App\Patterns\Builder;

/**
 * Products are resulting objects.
 * Products constructed by different builders
 * don’t have to belong to the same class hierarchy or interface.
 */
class House
{
    private string $foundation;
    private string $roof;
    private string $walls;
    private string $rooms;
    private string $garden;
    private string $garage;

    public function setFoundation(string $foundation): void
    {
        $this->foundation = $foundation;
    }

    public function setRoof(string $roof): void
    {
        $this->roof = $roof;
    }

    public function setWalls(string $walls): void
    {
        $this->walls = $walls;
    }

    public function addRooms(string $rooms): void
    {
        $this->rooms = $rooms;
    }


    public function addGarden(string $garden): void
    {
        $this->garden = $garden;
    }

    public function addGarage(string $garage): void
    {
        $this->garage = $garage;
    }



}
