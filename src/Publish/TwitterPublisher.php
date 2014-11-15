<?php

namespace Flock\Publish;

use Flock\Config\AbstractConfigProvider;
use Flock\FlockConfigException;
use Flock\Storage\IPublishStorage;
use TwitterOAuth;
use IPublisher;

class TwitterPublisher implements IPublisher {

    /** @var AbstractConfigProvider */
    private $configProvider;
    
    /** @var TwitterOAuth */
    private $twitterConnection;
    /**
     * @var \Flock\Storage\IPublishStorage
     */
    private $publishStorage;

    public function __construct(IPublishStorage $publishStorage, AbstractConfigProvider $configProvider) {
        $this->publishStorage = $publishStorage;
        $this->configProvider = $configProvider;
    }

    public function publish() {
        $toBePushedBack = [];
        foreach (StaticAccountListProvider::provideAccounts() as $account) {
            try {
                $connection = $this->getTwitterConnection($account);
            } catch (FlockConfigException $ex) {
                continue;
            }

            while (null !== ($tweetId = $this->publishStorage->getTweetId($account))) {
                $connection->post("statuses/retweet/" . $tweetId);
                if ($connection->lastStatusCode() !== 200) {
                    $toBePushedBack[$account][] = $tweetId;
                }
            }
        }
        //clean up
        $this->pushBackToSet($toBePushedBack);
    }

    /**
     * Pushes problematic tweets back to the the storage
     *
     * @param array[] $problematicTweets
     */
    private function pushBackToSet($problematicTweets) {
        foreach ($problematicTweets as $accountName => $tweetIds) {
            foreach ($tweetIds as $tweetId) {
                $this->publishStorage->toBePublished($accountName, $tweetId);
            }
        }
    }
    
    private function getTwitterConnection($account) {
        $consumer = $this->configProvider->getConsumerSecretPair();
        $tokens = $this->configProvider->getAuthPair($account);
        if($this->twitterConnection === null) {
            return new TwitterOAuth(
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
