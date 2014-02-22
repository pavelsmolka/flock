<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 2/12/14
 * Time: 9:44 PM
 */

namespace Flock\Assessment;


use Flock\Fetch\User;
use Flock\Storage\RedisPublishStorage;
use Flock\Storage\RedisUserBasedStorage;
use stdClass;

class DummyAssessment implements IAssessment {

    const PROGRAMOVANI_CZ = 'programovaniCZ';
    const VARENI = 'vareni';

    protected $rules = [
        'honzajavorek' => [self::PROGRAMOVANI_CZ],
        'geekovo' => [self::PROGRAMOVANI_CZ],
        'ostoweb' => [self::PROGRAMOVANI_CZ],
        'marek_jelen' => [self::PROGRAMOVANI_CZ],
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