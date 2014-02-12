<?php

use Flock\Assessment\DummyAssessment;

require_once "../../vendor/autoload.php";

$assessment = new DummyAssessment();

$assessment->work();