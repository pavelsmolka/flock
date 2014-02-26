<?php

namespace Flock\Storage;

use Redis;

class ProcessedStorage extends RedisStorage implements IProcessedStorage {
    
    const STORAGE_NAME = "p-tweets";
    
    public function saveTweet($tweetId) {
        $result = $this->redis->sAdd(self::STORAGE_NAME, $tweetId);
        if($result != 1) {
            //TODO: Log here
        }
    }
    
    public function isStored($tweetId) {
        return $this->redis->sContains(self::STORAGE_NAME, $tweetId);
    }

}
