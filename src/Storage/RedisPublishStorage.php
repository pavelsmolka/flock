<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 2/12/14
 * Time: 9:48 PM
 */

namespace Flock\Storage;


use Redis;

class RedisPublishStorage implements IPublishStorage {

    /** @var Redis  */
    protected $redis;

    public function __construct() {
        $this->redis = new Redis();
        $this->redis->connect('localhost');
    }

    public function toBePublished($accountId, $tweetId) {
        // TODO check if we have already published this tweet ID (control hash)
        // if yes -> discard
        // if no  -> save tweet id to $accountId set
        echo "We would publish tweet $tweetId to account $accountId\n";
    }

    public function getTweetId($accountId) {
        // TODO: Implement getTweetId() method.
    }
}