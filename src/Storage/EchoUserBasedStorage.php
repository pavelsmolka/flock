<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 2/10/14
 * Time: 10:56 PM
 */

namespace Flock\Storage;


use Flock\Fetch\User;

class EchoUserBasedStorage implements IUserBasedStorage {

    public function saveTweets(User $user, array $tweets) {
        echo "For user $user->userName...\n";
        echo "...we have " . count($tweets) . " tweets...\n";
        $pick = mt_rand(0, 19);
        if (isset($tweets[$pick])) {
            echo "...out of which the $pick. tweet says: '" . $tweets[$pick]->text . "'.\n\n";
        }
    }

    public function getTweet(User $user) {
        return null;
    }
}