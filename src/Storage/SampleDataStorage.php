<?php

namespace Flock\Storage;

use stdClass;

class SampleDataStorage implements IUserBasedStorage {

    protected $sampleData = ['pavelsmolka' => 432929526138404864, 'VolmutJ' => 429570848576393218];
    protected $sampleTweets = [];

    public function __construct() {
        foreach($this->sampleData as $userName => $tweetId) {
            $this->sampleTweets[] = $this->buildSampleTweet($userName, $tweetId);
        }
    }

    /**
     * @param stdClass[] $tweets
     * @throws \FlockException
     */
    public function saveTweets(array $tweets) {
        throw new \FlockException("Cannot save tweets into SampleDataStorage");
    }

    /**
     * @return stdClass|null
     */
    public function getTweet() {
        return array_pop($this->sampleTweets);
    }

    protected function buildSampleTweet($userName, $tweetId) {
        $tweet = new stdClass();
        $tweet->id = $tweetId;
        $tweet->user = new stdClass();
        $tweet->user->screen_name = $userName;
        return $tweet;
    }
}