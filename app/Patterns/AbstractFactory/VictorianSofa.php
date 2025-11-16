<?php
namespace App\Patterns\AbstractFactory;


class VictorianSofa implements Sofa
{
    public function lounge(): string
    {
        return 'Lounging on a Victorain Sofa';
    }
}
