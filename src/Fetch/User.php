<?php

namespace Flock\Fetch;


class User {

    /** @var string */
    public $userName;

    public function __construct($userName) {
        $this->userName = $userName;
    }

} 