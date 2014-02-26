<?php

use Flock\Assessment\AssessmentWorker;
use Flock\Assessment\DummyAssessment;
use Flock\Assessment\EchoAssessmentWorker;
use Flock\Assessment\HonzaAssessment;
use Flock\Storage\RedisPublishStorage;
use Flock\Storage\RedisUserBasedStorage;
use Flock\Storage\SampleDataStorage;

require_once "../../vendor/autoload.php";

$assessment = new DummyAssessment();

$sourceStorage = new RedisUserBasedStorage();
//$sourceStorage = new SampleDataStorage();

$resultStorage = new RedisPublishStorage();

$worker = new AssessmentWorker($sourceStorage, $resultStorage, $assessment);

$worker->work();