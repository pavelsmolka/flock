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

class RedisUserBasedStorage extends RedisStorage implements IUserBasedStorage {

    const STORAGE_TABLE = 's-tweets';
    
    /**
     * @param stdClass[] $tweets
     */
    public function saveTweets(array $tweets) {
        foreach($tweets as $tweet) {
            $this->redis->sAdd(self::STORAGE_TABLE, json_encode($tweet));
        }
    }

    /**
     * @return stdClass|null
     */
    public function getTweet() {
        $tweet = $this->redis->sPop(self::STORAGE_TABLE);
        if ($tweet) {
            return json_decode($tweet);
        } else {
            return null;
        }

    }
}