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
    use App\Patterns\Facade\YTDownloaderFacade;
    use App\Patterns\Facade\FFMpeg;
    use App\Patterns\Facade\FileStorage;
    use App\Patterns\Facade\YT;
    use App\Patterns\Decorator\SmsDecorator;
    use App\Patterns\Decorator\BasicNotifier;
    use App\Patterns\Decorator\SlackDecorator;
    use App\Patterns\Decorator\FacebookDecorator;
    use App\Patterns\Flyweight\MovingParticle;
    use App\Patterns\Flyweight\ParticleFactory;
    use App\Patterns\Flyweight\ParticleUnit;
    use App\Patterns\Proxy\PaymentProxy;

    use App\Patterns\ChainOfResponsibility\RateLimitHandler;
    use App\Patterns\ChainOfResponsibility\AuthenticationHandler;
    use App\Patterns\ChainOfResponsibility\AuthorizationHandler;
    use App\Patterns\ChainOfResponsibility\ControllerHandler;
    use App\Patterns\ChainOfResponsibility\Request as ChainRequest;

    use App\Patterns\Command\CommandInvoker;
    use App\Patterns\Command\Editor;
    use App\Patterns\Command\AppendTextCommand;
    use App\Patterns\Command\ReplaceTextCommand;
    use App\Patterns\Iterator\SocialGraphNetwork;
    use Pest\Configuration\Project;

    use App\Patterns\Iterator\Profile;

    use function Symfony\Component\String\s;

    Artisan::command('inspire', function () {
        $this->comment(Inspiring::quote());
    })->purpose('Display an inspiring quote');

    /**
     * factory
     * creational design pattern
     * its let you to create a interface for an object in a superclass
     * that lets you create objects without exposing
     * the exact class that will be instantiated
     *
     * it works by defining an interface (or abstract class)
     * and letting subclasses decide which concrete object to create.
     *
     * its useful when object creation logic is complex
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
     * builder design pattern
     * is a Creational Design pattern
     * that let you construct a complex object
     * in a step by step way
     *
     * its like building a house in step by step way but different implementation!
     * this pattern allow you to produce different type of object using same construction code.
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

    /**
     * Prototype is a creational design pattern that lets you
     * copy existing objects without making your code dependent on their classes.
     */
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

    /**
     * is a creational design pattern that lets
     * you ensure that a class has only one instance
     */
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

    /**
     * Adapter is a structural design pattern
     * that allows objects with incompatible interfaces to collaborate.
     * its like using a power plug adapter:
     * the plug does not fit the socket directly,
     * so the adapter makes them compatible without changing the plug.
     *
     * this pattern is useful when you want to reuse existing classes
     * but their interfaces do not match what the client expects.
     */
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

    /**
     * Bridge is a structural design pattern that separates the two main parts:
     * the abstraction and the implementation.
     * The abstraction defines the high-level behavior,
     * while the implementation handles the specific, detailed logic.
     * Both can change independently without affecting each other.
     *
     * Remote → Abstraction
     * TV (Sony, LG, Samsung) → Implementation
     * Seperating the idea into reality
     *
     */
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

    /**
     * its a Structural design pattern that let you compose a object into tree structure
     *
     * and then work with these structures as if they were individual objects.
     * its like putting items into a box, then putting that box
     * into a bigger box, and still treating everything as just
     * "one item" when you count or use it.
     *
     * whether its a single product or a bundle of products,
     * you interact with them the same way.
     */
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

    /**
     * is a structural design pattern that lets you attach new behaviors
     * to objects by placing these objects
     * inside special wrapper objects that contain the behaviors.
     *
     * layman's term:
     * its like putting layers on something.
     * you start with a basic object, then wrap it with
     * additional features one by one (SMS, Slack, Facebook).
     *
     * each wrapper adds a new behavior, and you can combine
     * them in any order you want.
     */
    Artisan::command('gof:decorator {message} {--sms} {--slack} {--fb}', function (string $message) {
        $sms = (bool) $this->option('sms');
        $slack = (bool) $this->option('slack');
        $fb = (bool) $this->option('fb');

        $this->comment(
            "Decorator demo (notifier): message='{$message}' "
                . "sms=" . ($sms ? 'on' : 'off') . " "
                . "slack=" . ($slack ? 'on' : 'off') . " "
                . "fb=" . ($fb ? 'on' : 'off')
        );

        $notifier = new BasicNotifier();

        if ($sms) {
            $notifier = new SmsDecorator($notifier);
        }
        if ($slack) {
            $notifier = new SlackDecorator($notifier);
        }
        if ($fb) {
            $notifier = new FacebookDecorator($notifier);
        }
    });

    /**
     * Facade is a structural design pattern that provides a simplified
     * interface to a library, a framework, or any other complex set of classes.
     * layman's term:
     * its like pressing one button instead of
     * manually doing many steps.
     * you dont need to know how things work inside,
     * you just use the simple interface.
     */
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
            $this->info('Downloaded video ID: ' . $result['id']);
            $this->info('Save as: ' . $result['filename']);
            $this->info('Path:' . $result['path']);
        } catch (Throwable $e) {
            $this->error('Download failed: ' . $e->getMessage());
        }
    });


    /**
     * Its a Structural Design pattern that lets you fit more object into the
     * available amount of RAM
     *
     * store shared data once, and let everybody reuse it.
     * its like having one design and letting thousands
     * of objects reuse it, instead of copying it
     * over and over again.
     */
    Artisan::command('gof:flyweight {--type=spark} {--count=10000} {--size=2}', function () {
        $typeName = (string) $this->option(('type'));
        $count = (int) $this->option('count');
        $size = (int) $this->option('size');

        $this->comment("Flyweight demo (particles): type=$typeName count=$count size=$size");

        $factory = new ParticleFactory();
        $unit = new ParticleUnit($factory);

        $texture = match ($typeName) {
            'spark' => 'spark.png',
            'smoke' => 'smoke.png',
            'fire' => 'fire.png',
            default => 'particle.png',
        };
        $color = match ($typeName) {
            'spark' => 'orange',
            'smoke' => 'gray',
            'fire' => 'red',
            default => 'white',
        };

        $unit->spawn($typeName, $texture, $color, $size, $count);

        $this->comment('Shared particles types: ' . $factory->count());
        $this->comment('Particles active: ' . $unit->count());

        for ($i = 1; $i <= 3; $i++) {
            $unit->step(1);
            $this->info('Step ' . $i . ' active=' . $unit->count());
            $this->line($unit->renderSample(5));
        }
    });


    /***
     * Proxy is a structural design pattern that lets you provide a
     * substitute or placeholder for another object. A proxy controls access to
     * the original object, allowing you to perform something either
     * before or after the request gets through to the original object.
     *
     * is a middleman that checks, controls, and protects payment
     * requests before they reach the real payment system.
     */

    Artisan::command('gof:proxy {amount} {--currency=USD} {--token=tok_demo} {--repeat=3}', function (float $amount) {
        $currency = (string) $this->option('currency');
        $token = (string) $this->option('token');
        $repeat = (int) $this->option('repeat');

        $this->comment("Proxy demo (Payment):  amount=$amount currency=$currency");

        $proxy = new PaymentProxy();


        for ($i = 1; $i <= $repeat; $i++) {
            $result = $proxy->charge($amount, $currency, $token);
            $this->info("Attempt $i: " . $result);
        }
    });


    /**
     * Chain of Responsibility is a behavioral design pattern
     * that lets you pass requests along a chain of handlers. Upon receiving a request,
     * each handler decides either to process the request or to pass it to the next handler in the chain.
     */

    Artisan::command('gof:chain {--token=tok_user} {--roles=user} {--action=read} {--limit=3} {--attempts=5}', function () {
        $token = (string) $this->option('token');
        $roles = array_values(array_map('trim', explode(',', (string) $this->option('roles'))));

        $action  = (string) $this->option('action');
        $limit   = (int) $this->option('limit');
        $attempts = (int) $this->option('attempts');

        $this->comment("Chain demo: token=$token roles=" . implode(',', $roles) . " action=$action limit=$limit attempts=$attempts");

        $rate = new RateLimitHandler($limit);
        $authn = new AuthenticationHandler();
        $authz = new AuthorizationHandler();
        $ctrl = new ControllerHandler();

        $rate->setNext($authn)->setNext($authz)->setNext($ctrl);

        for ($i = 1; $i <= $attempts; $i++) {
            $req = new ChainRequest($token, $roles, $action);
            $result = $rate->handle($req);
            $this->info("attempt $i: " . $result);
        }
    });

    /**
     * Command is a behavioral design pattern that turns a request
     * into a stand-alone object that contains all information about the request.
     * This transformation lets you pass requests as a method arguments, delay or
     * queue a request’s execution, and support undoable operations.
     */

    Artisan::command('gof:command {--undo=2}', function () {
        $undo = (int) $this->option('undo');

        $editor = new Editor();
        $invoker = new CommandInvoker();

        $this->comment('Command demo (editor): start text=""');
        $s1 = $invoker->run(new AppendTextCommand($editor, 'Hello'));
        $this->info('Exec append "Hello": ' . $s1);
        $s2 = $invoker->run(new AppendTextCommand($editor, 'World'));
        $this->info('Exec append "World": ' . $s2);
        $s3 = $invoker->run(new ReplaceTextCommand($editor, 'Hi'));
        $this->info('Exec replace "Hi" : ' . $s3);

        $undos = $invoker->undo($undo);
        foreach ($undos as $i => $state) {
            $this->info('Undo #' . ($i + 1) . ': ' . $state);
        }
    });

    /**
     * Iterator is a behavioral design pattern that lets you traverse elements
     * of a collection without exposing its underlying representation
     * (list, stack, tree, etc.).
     *
     * Iterator = access elements one by one without knowing how they’re stored.
     */

    Artisan::command('gof:iterator {--user=alice} {--relation=friends} {--limit=5}', function () {
        $user = (string) $this->option('user');
        $relation = strtolower((string) $this->option('relation'));
        $limit = (int) $this->option('limit');

        $this->comment("Iterator demo(social): user=$user relation=$relation limit=$limit");

        $net = new SocialGraphNetwork();

        $alice = new Profile('alice', 'Alice');
        $bob = new Profile('bob', 'Bob');
        $carol = new Profile('carol', 'Carol');
        $dave  = new Profile('dave', 'Dave');
        $erin  = new Profile('erin', 'Erin');

        $alice->addFriend('bob');
        $bob->addFriend('alice');
        $alice->addFriend('carol');
        $carol->addFriend('alice');
        $bob->addFriend('dave');
        $dave->addFriend('bob');

        $alice->addFollower('erin');
        $alice->addFollower('dave');
        $carol->addFollower('alice');

        foreach ([$alice, $bob, $carol, $dave, $erin] as $p) {
            $net->addProfile($p);
        }

        $it = match ($relation) {
            'friends' => $net->createFriendsIterator($user),
            'followers' => $net->createFollowersIterator($user),
            default => $net->createFriendsIterator($user),
        };

        $count = 0;
        while ($it->hasNext() && $count < $limit) {
            $p = $it->next();

            if ($p) {
                $this->info($p->getId().': '.$p->getName());
                $count++;
            }else {
                break;
            }
        }
    });

