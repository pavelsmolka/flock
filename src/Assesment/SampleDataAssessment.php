<?php
namespace Flock\Assessment;

use Flock\Assessment\IAssessment;
use \Redis;

class SampleDataAssessment implements IAssessment {
    
    public function assess() {
        $tweets = $this->createTestingData();
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        foreach($tweets as $tweet) {
            $redis->sAdd("programovaniCZ", json_encode($tweet));
        }
    }

    private  function popData() {
        return $this->createTestingData();
    }

    private function createTestingData() {
        return [432929526138404864, 429570848576393218];
    }

    private function pushData() {

    }
}