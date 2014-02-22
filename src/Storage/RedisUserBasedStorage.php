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
     * @param stdClass[] $tweets
     */
    public function saveTweets(array $tweets) {
        foreach($tweets as $tweet) {
            $this->redis->sAdd('s-tweets', json_encode($tweet));
        }
    }

    /**
     * @return stdClass|null
     */
    public function getTweet() {
        $tweet = $this->redis->sPop('s-tweets');
        if ($tweet) {
            return json_decode($tweet);
        } else {
            return null;
        }

    }
}