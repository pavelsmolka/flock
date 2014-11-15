<?php

use Flock\Assessment\AssessmentWorker;
use Flock\Assessment\DummyAssessment;
use Flock\Assessment\EchoAssessmentWorker;
use Flock\Assessment\HonzaAssessment;
use Flock\Storage\RedisPublishStorage;
use Flock\Storage\RedisUserBasedStorage;
use Flock\Storage\ProcessedStorage;

require_once __DIR__ . "/../../vendor/autoload.php";

$assessment = new DummyAssessment();

$sourceStorage = new RedisUserBasedStorage();
//$sourceStorage = new SampleDataStorage();
$resultStorage = new RedisPublishStorage();
$processedStorage = new ProcessedStorage();

$worker = new AssessmentWorker($sourceStorage, $resultStorage, $processedStorage, $assessment);

$worker->work();