<?php

namespace App\Patterns\Iterator;

class FriendsIterator implements ProfileIterator
{
    private SocialNetwork $network;
    private string $originId;
    private array $ids = [];
    private int $pos = 0;


    public function __construct(SocialNetwork $network, string $originId)
    {
        $this->network = $network;
        $this->originId = $originId;
        $origin = $this->network->getProfile($originId);
        $this->ids = $origin ? $origin->getFriendIds() : [];
    }


    public function hasNext(): bool
    {
        return $this->pos < count($this->ids);
    }

    public function next(): ?Profile
    {
        if(!$this->hasNext()) {
            return null;
        }

        $id = $this->ids[$this->pos++];
        return $this->network->getProfile($id);
    }

    public function reset(): void
    {
        $this->pos = 0;
    }
}
