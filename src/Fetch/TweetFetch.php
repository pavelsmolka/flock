<?php

namespace Flock\Fetch;

use Flock\Storage\IUserBasedStorage;
use TwitterAPIExchange;

class TweetFetch {

    /** @var array */
    protected $settings;

    /** @var StaticUsersListProvider */
    private $usersListProvider;
    /**
     * @var \Flock\Storage\IUserBasedStorage
     */
    private $storage;

    public function __construct(ConfigProvider $configProvider, IUserBasedStorage $storage) {
        $this->settings = $configProvider->getConsumerSecretPair();
        $this->usersListProvider = new StaticUsersListProvider();
        $this->storage = $storage;
    }

    public function fetchTweets() {

        $url = 'statuses/user_timeline';

        foreach($this->usersListProvider->getUsers() as $user) {

            // The alphabetical order of parameters matters, because of oAuth
            // Max 20 tweets and include retweets
            $parameters = [
                "screen_name" => $user->userName,
                "count" => 20,
                "include_rts" => 1,
                ];

            $api = new \TwitterOAuth($this->settings["consumer_key"], $this->settings["consumer_secret"]);
            $jsonResult = $api->get($url, $parameters);
            
            // Enjoy the happiness
            $tweets = $jsonResult;
            $this->storage->saveTweets($tweets);
        }

    }
} 