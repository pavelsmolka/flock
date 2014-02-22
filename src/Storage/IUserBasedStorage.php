<?php

namespace Flock\Storage;


use Flock\Fetch\User;
use stdClass;

interface IUserBasedStorage {

    /**
     * @param stdClass[] $tweets
     */
    public function saveTweets(array $tweets);

    /**
     * @return stdClass|null
     */
    public function getTweet();

} 