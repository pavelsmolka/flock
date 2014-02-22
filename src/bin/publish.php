<?php

use Flock\Publish\TwitterPublisher;
use Flock\Fetch\ConfigProvider;
use Flock\Storage\RedisPublishStorage;

require_once "../../vendor/autoload.php";

$configProvider = new ConfigProvider(__DIR__ . '/../../config/config2.ini');

$dataStorage = new RedisPublishStorage();

$publisher = new TwitterPublisher($dataStorage, $configProvider);
$publisher->publish();