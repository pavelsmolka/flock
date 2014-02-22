<?php

use Flock\Assessment\AssessmentWorker;
use Flock\Assessment\DummyAssessment;
use Flock\Storage\RedisPublishStorage;
use Flock\Storage\RedisUserBasedStorage;

require_once "../../vendor/autoload.php";

$assessment = new DummyAssessment();
$sourceStorage = new RedisUserBasedStorage();
$resultStorage = new RedisPublishStorage();

$worker = new AssessmentWorker($sourceStorage, $resultStorage, $assessment);

$worker->work();