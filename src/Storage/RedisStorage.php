<?php

namespace Flock\Storage;

use Redis;

/**
 * Main class of classes using Redis storage
 */
class RedisStorage {
    
    /**
     * @var Redis
     */
    protected $redis;

    public function __construct($host = "127.0.0.1", $port = 6379) {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);
    }
}
