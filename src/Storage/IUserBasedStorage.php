<?php

namespace Flock\Storage;


use Flock\Fetch\User;

interface IUserBasedStorage {

    public function saveTweets(User $user, array $tweets);

} 