<?php

namespace Flock\Publish;

use \Redis;
use \TwitterAPIExchange;
use Flock\Fetch\ConfigProvider;
use TwitterOAuth;
use Flock\Publish\StaticAccountListProvider;
use FlockConfigException;

class TwitterPublisher {

    /** @var \Flock\Fetch\ConfigProvider */
    private $configProvider;
    private $redis;
    
    /** @var TwitterOAuth */
    private $twitterConnection;

    public function __construct($configProvider) {
        $this->configProvider = $configProvider;
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function publish() {
        $toBePushedBack = [];
        foreach (StaticAccountListProvider::provideAccounts() as $account) {
            try {
                $connection = $this->getTwitterConnection($account);
            } catch (FlockConfigException $ex) {
                continue;
            }
            $tweetId = $this->redis->sPop($account);
            while ($tweetId != false) {
                $connection->post("statuses/retweet/" . $tweetId);
                if ($connection->lastStatusCode() !== 200) {
                    $toBePushedBack[$account][] = $tweetId;
                }
                $tweetId = $this->redis->sPop($account);
            }
        }
        //clean up
        $this->pushBackToSet($toBePushedBack);
    }

    /**
     * Pushes problematic tweets back to the redis set 
     * @param array of arrays11 $problematicTweets
     */
    private function pushBackToSet($problematicTweets) {
        foreach ($problematicTweets as $key => $tweetIds) {
            foreach ($tweetIds as $tweetId) {
                $this->redis->sAdd($key, $tweetId);
            }
        }
    }
    
    private function getTwitterConnection($account) {
        $consumer = $this->configProvider->getConsumerSecretPair();
        $tokens = $this->configProvider->getAuthPair($account);
        if($this->twitterConnection === null) {
            return new \TwitterOAuth(
                    $consumer["consumer_key"],
                    $consumer["consumer_secret"],
                    $tokens["oauth_access_token"],
                    $tokens["oauth_access_token_secret"]
            );
        } else {
            $this->twitterConnection->setOAuthToken(
                    $tokens["oauth_access_token"],
                    $tokens["oauth_access_token_secret"]);
            return $this->twitterConnection;
        }
    }

}
