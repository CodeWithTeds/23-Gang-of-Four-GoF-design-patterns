<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Patterns\Factory\TransportFactory;
use App\Patterns\AbstractFactory\ModernFurnitureFactory;
use App\Patterns\AbstractFactory\VictorianFurnitureFactory;
use App\Patterns\AbstractFactory\ArtDecoFurnitureFactory;
use App\Patterns\AbstractFactory\FurnitureFactory;
use App\Patterns\Builder\SimpleHouseBuilder;
use App\Patterns\Builder\LuxuryHouseBuilder;
use App\Patterns\Builder\Director;
use App\Patterns\Builder\ModernHouseBuilder;
use App\Patterns\Prototype\Circle;
use App\Patterns\Prototype\Rectangle;
use App\Patterns\Prototype\Square;

use function Symfony\Component\String\s;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * factory
 * creational design pattern
 * its let you to create a interface for an object in a superclass
 */
Artisan::command('gof:factory {type=bike}', function (string $type) {
    $this->comment('Factory demo: creating a transport for type: ' . $type);

    try {
        $transport = TransportFactory::create($type);
        $this->comment('Created: ' . get_class($transport));
        $this->info($transport->deliver());
    } catch (InvalidArgumentException $e) {
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

Artisan::command('gof:abstract-factory {family=modern}', function (string $family) {
    $this->comment('Abstract Factory demo: (furniture): creating family: ' . $family);

    try {
        $factory = match (strtolower($family)) {
            'modern' => new ModernFurnitureFactory(),
            'victorian' => new VictorianFurnitureFactory(),
            'art' => new ArtDecoFurnitureFactory(),
            'default' => throw new InvalidArgumentException("Uknown family:" . $family),
        };

        $chair = $factory->createChair();
        $sofa = $factory->createSofa();

        $this->comment('Chair Class: ' . get_class($chair));
        $this->comment('Sofa Class: ' . get_class($sofa));
        $this->info($sofa->lounge());
        $this->info($chair->sit());
    } catch (InvalidArgumentException $e) {
        $this->error($e->getMessage());
    }
});

/**
 *
 * builder design pattern
 */
Artisan::command('gof:builder {type=simple} {--rooms=3} {--garage} {--garden}', function (string $type) {
    $rooms = (int) $this->option('rooms');
    $garage = (bool) $this->option('garage');
    $garden = (bool) $this->option('garden');

    $this->comment("Builder demo (House): type=$type rooms=$rooms garage=" . ($garage ? 'yes' : 'no') . " garden=" . ($garden ? 'yes' : 'no'));

    try {
        $builder = match (strtolower($type)) {
            'simple' => new SimpleHouseBuilder(),
            'luxury' => new LuxuryHouseBuilder(),
            'modern' => new ModernHouseBuilder(),
            'default' => throw new InvalidArgumentException("Uknown Builder: . {$type}"),
        };

        $director = new Director();
        $house = $director->construct($builder, $rooms, $garage, $garden);

        $this->comment('Builder class' . get_class($builder));
    } catch (InvalidArgumentException $e) {
        $this->error($e->getMessage());
    }
});


Artisan::command('gof:prototype {type=circle} {--x=0} {--y=0} {--size=50} {--fill=red} {--stroke=1}', function (string $type) {
    $x = (int) $this->option('x');
    $y = (int) $this->option('y');
    $size = (int) $this->option('size');
    $fill = (string) $this->option('fill');
    $stroke  = (int) $this->option('stroke');

    $this->comment("Prototype demo (Shape): type=$type at=($x, $y) size=$size fill=$fill stroke=$stroke");
    try {
        $prototype = match (strtolower($type)) {
            'circle' => new Circle(),
            'rectangle' => new Rectangle(),
            'square' => new Square(),
            'default' => throw new InvalidArgumentException("Uknown Prototype: . {$type}"),
        };

        // configure prototype defaults
        $prototype->setPosition(0, 0);
        $prototype->setStyle('gray', 2);

        if ($prototype instanceof Circle) {
            $prototype->setRadius(50);
        }

        if ($prototype instanceof Rectangle) {
            $prototype->setSize(100, 50);
        }

        if ($prototype instanceof Square) {
            $prototype->setSize(50, 50);
        }

        $clone = $prototype->duplicate();
        $clone->setPosition($x, $y);
        $clone->setStyle($fill, $stroke);

        $this->comment('Prototype Class: ' .get_class($prototype));
        $this->comment('Clone class: ' .get_class($clone));
        $this->info('Original: '.$prototype->describe());
        $this->info('Clone: ' .$clone->describe());
    } catch (Throwable $e) {
        $this->error($e->getMessage());
    }
});
