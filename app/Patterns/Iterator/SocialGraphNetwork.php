<?php

namespace App\Patterns\Iterator;

use App\Patterns\Iterator\FollowersIterator;
use App\Patterns\Iterator\FriendsIterator;

class SocialGraphNetwork implements SocialNetwork
{
    private array $profiles = [];

    public function getProfile(string $id): ?Profile
    {
        return $this->profiles[$id] ?? null;
    }

    public function addProfile(Profile $profile): void
    {
        $this->profiles[$profile->getId()] = $profile;
    }

    public function createFriendsIterator(string $id): ProfileIterator
    {
        return new FriendsIterator($this, $id);
    }

    public function createFollowersIterator(string $id): ProfileIterator
    {
        return new FollowersIterator($this, $id);
    }

}















