<?php

namespace Flock\Storage;


use Flock\Fetch\User;
use stdClass;

interface IUserBasedStorage {

    /**
     * @param User $user
     * @param stdClass[] $tweets
     */
    public function saveTweets(User $user, array $tweets);

    /**
     * @param User $user
     * @return stdClass|null
     */
    public function getTweet(User $user);

} 