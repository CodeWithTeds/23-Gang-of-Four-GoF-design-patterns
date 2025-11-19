<?php

namespace App\Patterns\Builder;


class Director
{
    public function construct(HouseBuilder $builder, int $rooms,  bool $garage, bool $garden): House
    {
        $builder->buildFoundation();
        $builder->buildStructure();
        $builder->buildRoof();
        $builder->addRooms($rooms);

        if ($garage){
            $builder->addGarage();
        }

        if ($garden){
            $builder->addGarden();
        }

        return $builder->getHouse();
    }
}
