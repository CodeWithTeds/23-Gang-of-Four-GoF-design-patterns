<?php

namespace App\Patterns\Builder;
/**
 *  Builder interface
 */
interface HouseBuilder
{
  public function buildFoundation(): void;
  public function buildStructure(): void;
  public function buildRoof(): void;

  public function addGarage(): void;
  public function addRooms(int $count): void;
  public function addGarden(): void;
  public function getHouse(): House;  
}
