<?php

namespace Flock\Storage;

use Redis;

class RedisPublishStorage implements IPublishStorage {

    /** @var Redis  */
    protected $redis;

    public function __construct() {
        $this->redis = new Redis();
        $this->redis->connect('localhost');
    }

    public function toBePublished($accountName, $tweetId) {
        $this->redis->sAdd($accountName, $tweetId);
    }

    public function getTweetId($accountName) {
        $tweetId = $this->redis->sPop($accountName);
        return ($tweetId === false) ? null : $tweetId;
    }
}