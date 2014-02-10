<?php

namespace Flock\Fetch;

class StaticUsersListProvider {

    protected $users;

    public function __construct() {
        $this->users = [
            new User('honzajavorek'),
            new User('marek_jelen'),
            new User('geekovo'),
            new User('ostoweb'),
        ];
    }

    /**
     * @return User[]
     */
    public function getUsers() {
        return $this->users;
    }

} 