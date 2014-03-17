<?php

use Flock\Assessment\AssessmentWorker;
use Flock\Assessment\DummyAssessment;
use Flock\Assessment\PavelAssessment;
use Flock\Storage\RedisPublishStorage;
use Flock\Storage\RedisUserBasedStorage;
use Flock\Storage\SampleDataStorage;

require_once "../../vendor/autoload.php";

$assessment = new PavelAssessment();

$sourceStorage = new RedisUserBasedStorage();
//$sourceStorage = new SampleDataStorage();

$resultStorage = new RedisPublishStorage();

$worker = new AssessmentWorker($sourceStorage, $resultStorage, $assessment);

$worker->work();