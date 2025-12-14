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
use App\Patterns\Singleton\Logger;
use App\Patterns\Adapter\RoundHole;
use App\Patterns\Adapter\RoundPeg;
use App\Patterns\Adapter\RoundPegInterface;
use App\Patterns\Adapter\SquarePeg;
use App\Patterns\Adapter\SquarePegAdapter;
use App\Patterns\Bridge\Blue;
use App\Patterns\Bridge\Green;
use App\Patterns\Bridge\Red;
use App\Patterns\Bridge\Circle as BridgeCircle;
use App\Patterns\Bridge\Rectangle as BridgeRectangle;
use App\Patterns\Composite\OrderBundle;
use App\Patterns\Composite\OrderItem;
use App\Patterns\Decorator\SmsDecorator;
use App\Patterns\Facade\YTDownloaderFacade;
use App\Patterns\Facade\FFMpeg;
use App\Patterns\Facade\FileStorage;
use App\Patterns\Facade\YT;


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

        $this->comment('Prototype Class: ' . get_class($prototype));
        $this->comment('Clone class: ' . get_class($clone));
        $this->info('Original: ' . $prototype->describe());
        $this->info('Clone: ' . $clone->describe());
    } catch (Throwable $e) {
        $this->error($e->getMessage());
    }
});


Artisan::command('gof:singleton {messages*}', function (array $messages) {

    $this->comment("Singleton Logger Demo: logging message via shared instance");

    try {

        $loggerA = Logger::getInstance();
        $loggerB = Logger::getInstance();

        $this->comment("Logger ID (A): " . $loggerA->getId());
        $this->comment("Logger ID (B): " . $loggerB->getId());

        foreach ($messages as $msg) {
            $loggerA->log($msg);
        }

        $logsFromA = $loggerA->getLogs();
        $logsFromB = $loggerB->getLogs();

        $this->info("Logs (from A):" . json_encode($logsFromA));
        $this->info("Logs (from B):" . json_encode($logsFromB));
    } catch (Throwable $e) {
        $this->error($e->getMessage());
    }
});

Artisan::command('gof:adapter {peg=round} {--hole=50} {--size=30}', function (string $peg) {
    $holeRadius = (float) $this->option('hole');
    $size = (float) $this->option('size');

    $this->comment("Adapter demo (peg-in-hole): peg=$peg hole=$holeRadius size=$size");
    $hole = new RoundHole($holeRadius);

    try {
        switch (strtolower($peg)) {
            case 'round':
                $roundPeg = new RoundPeg($size);
                $fits = $hole->fits($roundPeg);
                $this->comment($hole->describe());
                $this->comment($roundPeg->describe());
                $this->info($fits ? 'Result: round peg FITS the hole' : 'Result: round peg DOES NOT fit the hole');
                break;

            case 'square':
                $squarePeg = new SquarePeg($size);
                $adapter = new SquarePegAdapter($squarePeg);
                $fits = $hole->fits($adapter);
                $this->comment($hole->describe());
                $this->comment($adapter->describe());
                $this->info($fits ? 'Result: square peg FITS the hole' : 'Result: square peg DOES NOT fit the hole');
                break;

            default:
                throw new InvalidArgumentException("Uknown peg type: {$peg}");
        }
    } catch (Throwable $e) {
        $this->error($e->getMessage());
    }
});


Artisan::command('gof:Bridge {shape=circle} {--color=red} {--size=50}', function (string $shape) {
    $colorOpt = strtolower((string) $this->option('color'));
    $size = (int) $this->option('size');

    $this->comment("bridge demo (shape + color) : shape=$shape color=$colorOpt size=$size");

    $color = match ($colorOpt) {
        'red' => new Red(),
        'green' => new Green(),
        'blue' => new Blue(),
        'default' => throw new InvalidArgumentException("Uknown bridge: . {$colorOpt}"),
    };

    try {
        switch (strtolower($shape)) {
            case 'circle':
                $obj = new BridgeCircle($color);
                $obj->setRadius($size);
                $this->info($obj->draw());
                break;
            case 'rectangle':
                $obj = new BridgeRectangle($color);
                $obj->setSize($size, $size);
                $this->info($obj->draw());
                break;
            default:
                throw new InvalidArgumentException("Uknown shape: {$shape}");
        }
    } catch (Throwable $e) {
        $this->error($e->getMessage());
    }
});

Artisan::command('gof:composite {--discount=10} {--nested}', function () {
    $discount = (float) $this->option('discount');
    $nested = (bool) $this->option('nested');

    $this->comment("Composite demo (complex order): discount=$discount% nested=" . ($nested ? 'yes' : 'no'));

    $order = new OrderBundle('Customer Order');

    // Base items
    $order->add(new OrderItem('Laptop', 1200.00, 1));
    $order->add(new OrderItem('Mouse', 25.00, 2));

    // Office kit bundle
    $officekit = new OrderBundle('Office Kit');
    $officekit->add(new OrderItem('Notebook', 5.00, 3));
    $officekit->add(new OrderItem('Pen', 2.00, 5));

    if ($discount > 0) {
        $officekit->setDiscountPercent($discount);
    }

    if ($nested) {
        $accessoryPack = new OrderBundle('Accessory Pack');
        $accessoryPack->add(new OrderItem('Headset', 40.00, 1));
        $accessoryPack->add(new OrderItem('USB Hub', 20.00, 1));
        $accessoryPack->add(new OrderItem('Mouse Pad', 8.00, 1));
        $officekit->add($accessoryPack);

        // Only add if created
        $order->add($accessoryPack);
    }

    // Add officekit to order
    $order->add($officekit);

    $this->info('Composite Pattern demo: Complex Order');
    $this->line($order->describe());

    $this->info(sprintf('Grand total: $%.2f', $order->getTotal()));
});


Artisan::command('gof:facade {url} {--format=mp4}', function (string $url) {
    $format = (string) $this->option('format');

    $this->comment("Facade demo (YouTube downloader): format=$format url=$url");

    $facade = new YTDownloaderFacade(
        new YT(),
        new FFMpeg(),
        new FileStorage(),
    );

    try {
        $result = $facade->download($url, $format);
        $this->info('Downloaded video ID: ' .$result['id']);
        $this->info('Save as: ' .$result['filename']);
        $this->info('Path:' .$result['path']);
    }catch(Throwable $e){
        $this->error('Download failed: ' . $e->getMessage());
    }
});


