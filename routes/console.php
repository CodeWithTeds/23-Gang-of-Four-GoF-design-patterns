<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Patterns\Factory\TransportFactory;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('gof:factory {type=bike}', function (string $type){
    $this->comment('Factory demo: creating a transport for type: ' .$type);

    try{
        $transport = TransportFactory::create($type);
        $this->comment('Created: '.get_class($transport));
        $this->info($transport->deliver());
    }catch(InvalidArgumentException $e){
        $this->errorQQ($e->getMessage());
    }
});
