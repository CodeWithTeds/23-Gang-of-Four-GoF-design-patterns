<?php


namespace App\Patterns\AbstractFactory;

class ArtDecoFurnitureFactory implements FurnitureFactory
{
    public function createChair(): Chair
    {
        return new ArtDecoChair();
    }

    public function createSofa(): Sofa
    {
        return new ArtDecoSofa();
    }

}
