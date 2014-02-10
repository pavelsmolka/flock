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
        $this->settings = $configProvider->getConfig();
        $this->usersListProvider = new StaticUsersListProvider();
        $this->storage = $storage;
    }

    public function fetchTweets() {

        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $requestMethod = 'GET';

        foreach($this->usersListProvider->getUsers() as $user) {

            // The alphabetical order of parameters matters, because of oAuth
            $getField = "?screen_name=$user->userName";

            $api = new TwitterAPIExchange($this->settings);

            // Fields must be set first, in order for oAuth to be able to calculate the signature
            $jsonResult = $api
                ->setGetfield($getField)
                ->buildOauth($url, $requestMethod)
                ->performRequest();

            // Enjoy the happiness
            $tweets = json_decode($jsonResult);
            $this->storage->saveTweets($user, $tweets);
        }

    }
} 