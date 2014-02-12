<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 2/10/14
 * Time: 11:37 PM
 */

namespace Flock\Storage;


use Flock\Fetch\User;
use Redis;

class RedisUserBasedStorage implements IUserBasedStorage {

    /** @var Redis  */
    protected $redis;

    public function __construct() {
        $this->redis = new Redis();
        $this->redis->connect('localhost');
    }

    /**
     * @param User $user
     * @param array $tweets
     */
    public function saveTweets(User $user, array $tweets) {
        foreach($tweets as $tweet) {
            $this->redis->sAdd('s-' . $user->userName, json_encode($tweet));
        }
    }
}