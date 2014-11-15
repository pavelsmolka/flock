<?php

use Flock\Assessment\Worker\AssessmentWorker;
use Flock\Assessment\UserCategoryMapAssessment;
use Flock\Assessment\HonzaAssessment;
use Flock\Storage\RedisPublishStorage;
use Flock\Storage\RedisUserBasedStorage;
use Flock\Storage\ProcessedStorage;

require_once __DIR__ . "/../../vendor/autoload.php";

$assessment = new UserCategoryMapAssessment();

$sourceStorage = new RedisUserBasedStorage();
//$sourceStorage = new SampleDataStorgit statusage();
$resultStorage = new RedisPublishStorage();
$processedStorage = new ProcessedStorage();

$worker = new AssessmentWorker($sourceStorage, $resultStorage, $processedStorage, $assessment);

$worker->work();