<?php

use Flock\Config\EnvironmentConfigProvider;
use Flock\Config\IniFileConfigProvider;
use Flock\Fetch\TweetFetch;
use Flock\FlockException;
use Flock\Storage\RedisUserBasedStorage;


require_once __DIR__ . "/../../vendor/autoload.php";

//$configProvider = new IniFileConfigProvider(__DIR__ . '/../../config/config.ini');
$configProvider = new EnvironmentConfigProvider();
$tweetFetch = new TweetFetch($configProvider, new RedisUserBasedStorage());

$logger = new \Monolog\Logger("log");
$logger->pushHandler(new \Monolog\Handler\ErrorLogHandler());

try {

    $tweetFetch->setLogger($logger);
    $tweetFetch->fetchTweets();

} catch(FlockException $e) {
    echo $e->getMessage();
    exit;
} catch(Exception $e) {
	echo $e->getMessage();
	exit;
}
