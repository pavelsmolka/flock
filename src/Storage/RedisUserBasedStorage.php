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
use stdClass;

class RedisUserBasedStorage implements IUserBasedStorage {

    /** @var Redis  */
    protected $redis;

    public function __construct() {
        $this->redis = new Redis();
        $this->redis->connect('localhost');
    }

    /**
     * @param User $user
     * @param stdClass[] $tweets
     */
    public function saveTweets(User $user, array $tweets) {
        foreach($tweets as $tweet) {
            $this->redis->sAdd('s-' . $user->userName, json_encode($tweet));
        }
    }

    /**
     * @param User $user
     * @return stdClass|null
     */
    public function getTweet(User $user) {
        $tweet = $this->redis->sPop('s-' . $user->userName);
        if ($tweet) {
            return json_decode($tweet);
        } else {
            return null;
        }

    }
}