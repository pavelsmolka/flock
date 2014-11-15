<?php

use Flock\Config\EnvironmentConfigProvider;
use Flock\Publish\TwitterPublisher;
use \Flock\Publish\EchoPublisher;
use Flock\Config\IniFileConfigProvider;
use Flock\Storage\RedisPublishStorage;

require_once __DIR__ . "/../../vendor/autoload.php";

//$configProvider = new IniFileConfigProvider(__DIR__ . '/../../config/config.ini');
$configProvider = new EnvironmentConfigProvider();

$dataStorage = new RedisPublishStorage();

$publisher = new EchoPublisher($dataStorage, $configProvider);
$publisher->publish();