<?php

namespace Flock\Fetch;

use Flock\Config\AbstractConfigProvider;
use Flock\Config\IniFileConfigProvider;
use Flock\Storage\IUserBasedStorage;
use Psr\Log\LoggerAwareTrait;
use TwitterOAuth;

class TweetFetch {

    use LoggerAwareTrait;

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

        $this->logger->info('Fetching tweets.');
        $url = 'statuses/user_timeline';

        foreach($this->usersListProvider->getUsers() as $user) {

            $this->logger->info('Fetching tweets for user: ', ['user' => $user->userName]);

            // The alphabetical order of parameters matters, because of oAuth
            // Max 20 tweets and include retweets
            $parameters = [
                "screen_name" => $user->userName,
                "count" => 20,
                "include_rts" => 1,
            ];

            $tweets = $this->api->get($url, $parameters);
            
            // We might want to construct our own Tweet objects
            if (is_array($tweets)) {
                // Save results
                $this->logger->info('Saving tweets into redis: ', ['count' => count($tweets)]);
                $this->storage->saveTweets($tweets);
            } else {
                $this->logger->warning('Response is not array - probably error: ', ['response' => $tweets]);
            }

        }

    }
} 