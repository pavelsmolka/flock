<?php

namespace Flock\Fetch;

use Flock\Config\AbstractConfigProvider;
use Flock\Config\IniFileConfigProvider;
use Flock\Storage\IUserBasedStorage;
use TwitterOAuth;

class TweetFetch {

    /** @var TwitterOAuth */
    protected $api;

    /** @var StaticUsersListProvider */
    private $usersListProvider;
    /**
     * @var IUserBasedStorage
     */
    private $storage;

    public function __construct(AbstractConfigProvider $configProvider, IUserBasedStorage $storage) {
        $settings = $configProvider->getConsumerSecretPair();
        $oauth = $configProvider->getAuthPair('ProgramovaniCZ');
        $this->usersListProvider = new StaticUsersListProvider();
        $this->storage = $storage;

        $this->api = new TwitterOAuth(
            $settings["consumer_key"],
            $settings["consumer_secret"],
            $oauth['oauth_access_token'],
            $oauth['oauth_access_token_secret']
        );
    }

    public function fetchTweets() {

        $url = 'statuses/user_timeline';

        foreach($this->usersListProvider->getUsers() as $user) {

            // The alphabetical order of parameters matters, because of oAuth
            // Max 20 tweets and include retweets
            $parameters = [
                "screen_name" => $user,
                "count" => 20,
                "include_rts" => 1,
            ];

            $tweets = $this->api->get($url, $parameters);
            
            // We might want to construct our own Tweet objects
            if (is_array($tweets)) {
                // Save results
                $this->storage->saveTweets($tweets);
            } else {
                echo json_encode($tweets);
                echo "\n";
            }

        }

    }
} 