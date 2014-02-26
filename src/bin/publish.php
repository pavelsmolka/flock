<?php

use Flock\Publish\TwitterPublisher;
use \Flock\Publish\EchoPublisher;
use Flock\Fetch\ConfigProvider;
use Flock\Storage\RedisPublishStorage;

require_once "../../vendor/autoload.php";

$configProvider = new ConfigProvider(__DIR__ . '/../../config/config.ini');

$dataStorage = new RedisPublishStorage();

$publisher = new EchoPublisher($dataStorage, $configProvider);
$publisher->publish();