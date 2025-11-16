<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Patterns\Factory\TransportFactory;
use App\Patterns\AbstractFactory\ModernFurnitureFactory;
use App\Patterns\AbstractFactory\VictorianFurnitureFactory;
use App\Patterns\AbstractFactory\ArtDecoFurnitureFactory;
use App\Patterns\AbstractFactory\FurnitureFactory;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * factory
 * creational design pattern
 * its let you to create a interface for an object in a superclass
 */
Artisan::command('gof:factory {type=bike}', function (string $type){
    $this->comment('Factory demo: creating a transport for type: ' .$type);

    try{
        $transport = TransportFactory::create($type);
        $this->comment('Created: '.get_class($transport));
        $this->info($transport->deliver());
    }catch(InvalidArgumentException $e){
        $this->error($e->getMessage());
    }
});


/**
 * Abstract Factory
 * Creational Design pattern
 * Its let you produce a family of object
 * without specifying a concrete classes
 *
 */

Artisan::command('gof:abstract-factory {family=modern}', function (string $family){
    $this->comment('Abstract Factory demo: (furniture): creating family: ' . $family);

    try{
        $factory = match (strtolower($family)){
            'modern' => new ModernFurnitureFactory(),
            'victorian' => new VictorianFurnitureFactory(),
            'art' => new ArtDecoFurnitureFactory(),
            'default' => throw new InvalidArgumentException("Uknown family:" . $family),
        };

        $chair = $factory->createChair();
        $sofa = $factory->createSofa();

        $this->comment('Chair Class: '. get_class($chair));
        $this->comment('Sofa Class: '. get_class($sofa));
        $this->info($sofa->lounge());
        $this->info($chair->sit());

    }catch(InvalidArgumentException $e){
        $this->error($e->getMessage());
    }
});
