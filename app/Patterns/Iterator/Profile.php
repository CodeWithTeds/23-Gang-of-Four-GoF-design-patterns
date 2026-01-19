<?php

namespace App\Patterns\Iterator;

class Profile
{
    private string $id;
    private string $name;
    private array $friends = [];
    private array $followers = [];

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addFriend(string $id): void
    {
        if (!in_array($id, $this->friends, true)) {
            $this->friends[] = $id;
        }
    }

    public function addFollower(string $id): void
    {
        if (!in_array($id, $this->followers, true)) {
            $this->followers[] = $id;
        }
    }

    public function getFriendIds(): array
    {
        return $this->friends;
    }

    public function getFollowerIds(): array
    {
        return $this->followers;
    }
}
