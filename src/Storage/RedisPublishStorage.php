<?php

namespace Flock\Storage;

use Redis;

class RedisPublishStorage extends RedisStorage implements IPublishStorage {

    public function toBePublished($accountName, $tweetId) {
        $this->redis->sAdd($accountName, $tweetId);
    }

    public function getTweetId($accountName) {
        $tweetId = $this->redis->sPop($accountName);
        return ($tweetId === false) ? null : $tweetId;
    }
}