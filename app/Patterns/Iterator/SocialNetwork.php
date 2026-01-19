<?php

namespace App\Patterns\Iterator;

interface SocialNetwork
{
    public function getProfile(string $id): ?Profile;
    public function addProfile(Profile $profile): void;
    public function createFriendsIterator(string $id): ProfileIterator;
    public function createFollowersIterator(string $id): ProfileIterator;

}
