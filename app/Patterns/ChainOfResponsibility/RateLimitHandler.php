<?php

namespace App\Patterns\ChainOfResponsibility;


class RateLimitHandler extends Handler
{
    private int $max;
    private array $counters = [];

    public function __construct(int $max)
    {
        $this->max = $max;
    }

    public function handle (Request $req): string
    {
        $key = $req->token;
        $count = $this->counters[$key] ?? 0;
        if ($count >= $this->max){
            return 'BLOCK:rate_limit_exceeded';
        }
        $this->counters[$key] = $count + 1;
        return $this->pass($req);
    }


}
