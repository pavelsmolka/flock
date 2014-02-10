<?php

use Flock\Fetch\ConfigProvider;
use Flock\Fetch\TweetFetch;
use Flock\Storage\EchoUserBasedStorage;


require_once "../../vendor/autoload.php";

$configProvider = new ConfigProvider(__DIR__ . '/../../config/config.ini');
$tweetFetch = new TweetFetch($configProvider, new EchoUserBasedStorage());

try {

    $tweetFetch->fetchTweets();

} catch(FlockException $e) {
    echo $e->getMessage();
    exit;
} catch(Exception $e) {
	echo $e->getMessage();
	exit;
}
