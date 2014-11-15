<?php

namespace Flock\Storage;

use Redis;

/**
 * Main class of classes using Redis storage
 *
 * TODO Heroku RedisToGo should be handled better (use builder/factory?)
 */
class RedisStorage {

    /**
     * @var Redis
     */
    protected $redis;

    public function __construct($host = "127.0.0.1", $port = 6379) {

        $this->redis = new Redis();

        if (isset($_ENV['REDISTOGO_URL'])) {

            // Try connecting to the "Redis To Go" (Heroku)

            // Parse out the URL and set as session handler
            $redis_url = "tcp://" . parse_url($_ENV['REDISTOGO_URL'], PHP_URL_HOST) . ":" . parse_url($_ENV['REDISTOGO_URL'], PHP_URL_PORT);
            if (!is_array(parse_url($_ENV['REDISTOGO_URL'], PHP_URL_PASS))) {
                $redis_url .= "?auth=" . parse_url($_ENV['REDISTOGO_URL'], PHP_URL_PASS);
            }


            // Connecting to Redis for use PHP code directly (non-sessions)
            $this->redis->connect(parse_url($_ENV['REDISTOGO_URL'], PHP_URL_HOST), parse_url($_ENV['REDISTOGO_URL'], PHP_URL_PORT));
            if (!is_array(parse_url($_ENV['REDISTOGO_URL'], PHP_URL_PASS))) {
                $this->redis->auth(parse_url($_ENV['REDISTOGO_URL'], PHP_URL_PASS));
            }

        } else {

            // Fall back to local/remote host-port-based Redis
            $this->redis->connect($host, $port);
        }

    }

}
