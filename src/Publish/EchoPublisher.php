<?php

namespace Flock\Publish;

use Flock\Config\AbstractConfigProvider;
use IPublisher;
use Flock\Storage\IPublishStorage;

/**
 * This class just writes tweets to the output.
 * It is a proper implementation of publisher and might be used for
 * integration testing without posting tweets to twitter.
 * Although might serve as /dev/null equivalent.
 */
class EchoPublisher implements IPublisher {

    /** @var AbstractConfigProvider */
    private $configProvider;

    /**
     * @var \Flock\Storage\IPublishStorage
     */
    private $publishStorage;

    public function __construct(IPublishStorage $publishStorage, AbstractConfigProvider $configProvider) {
        $this->publishStorage = $publishStorage;
        $this->configProvider = $configProvider;
    }

    public function publish() {
        foreach (StaticAccountListProvider::provideAccounts() as $account) {
            while (null !== ($tweetId = $this->publishStorage->getTweetId($account))) {
                echo "Publishing tweet with id <b>" . $tweetId . "</b>"
                        . " to account <b>" . $account . "</b>.";
                echo "<br />";
            }
        }
    }

}
