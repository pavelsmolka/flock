<?php

use Flock\Assessment\SampleDataAssessment;
use Flock\Publish\TwitterPublisher;
use Flock\Fetch\ConfigProvider;

require_once "../../vendor/autoload.php";

$configProvider = new ConfigProvider(__DIR__ . '/../../config/config2.ini');



$assesment = new SampleDataAssessment();
$assesment->assess();

$publisher = new TwitterPublisher($configProvider);
$publisher->publish();