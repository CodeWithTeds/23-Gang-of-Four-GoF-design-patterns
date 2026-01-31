<?php

namespace App\Patterns\Mediator;

class ChatRoom implements ChatMediator
{
    private array $users = [];

    public function send(string $message, User $from, ?User $to = null): array
    {
        $results = [];

        if($to) {
            $id = $to->getId();
            if(isset($this->users[$id])) {
                $results[] = $this->users[$id]->receive($from, $message);
            }
            return $results;
        }

        foreach($this->users as $id => $u){
            if($u->getId() !== $from->getid()) {
                $results[] = $u->receive($from, $message);
            }
        }

        return $results;
    }

    public function register(User $user): void
    {
        $this->users[$user->getId()] = $user;
    }
}
