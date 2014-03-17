<?php

namespace Flock\Assessment;

use stdClass;

class DummyAssessment implements IAssessment {


    protected $rules = [
        'honzajavorek' => [self::PROGRAMOVANI_CZ],
        'geekovo' => [self::PROGRAMOVANI_CZ],
        'ostoweb' => [self::PROGRAMOVANI_CZ],
        'marek_jelen' => [self::PROGRAMOVANI_CZ],
        'VolmutJ' => [self::PROGRAMOVANI_CZ],
        'pavelsmolka' => [self::PROGRAMOVANI_CZ],
        'cuketka' => [self::VARENI],
    ];

    public function assess(stdClass $tweet) {

        if (!isset($tweet->user->screen_name)) {
            throw new \FlockException("Invalid tweet entity (does not contain screen_name");
        }

        $userName = $tweet->user->screen_name;

        if (isset($this->rules[$userName])) {
            return $this->rules[$userName];
        } else {
            return [];
        }

    }

} 