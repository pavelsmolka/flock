<?php
namespace Flock\Assessment;

/**
 * EchoAssessmentWorker is testing class for assessments whether they are 
 * working properly.
 * Class takes tweets from source storage, assess them and writes them
 * to output.
 * All tweets are shown but positively assessed are marked.
 * After all tweets are written out all tweets are put back to source storage
 * again.
 */
class EchoAssessmentWorker extends AssessmentWorker {
    
    public function work() {
        $pushBack = [];
        while (null !== ($tweet = $this->sourceStorage->getTweet())) {

            // Decide where to publish, using $this->assessment
            $accountsToPublish = $this->assessment->assess($tweet);
            if(empty($accountsToPublish)) {
                $this->echoizeTweet($tweet, false);
            } else {
                $this->echoizeTweet($tweet, true);
            }
            $pushBack[] = $tweet;
        }
        
        $this->sourceStorage->saveTweets($pushBack);
    }
    
    private function echoizeTweet($tweet, $isToBePublished) {
        if($isToBePublished) {
            echo "<b>";
        }
        echo $tweet->id;
        echo "<br />";
        echo $tweet->user->name;
        echo "<br />";
        echo "RT: " . $tweet->retweet_count;
        echo "<br />";
        echo "F: " . $tweet->favorite_count;
        echo "<br />";
        echo $tweet->text;
        if($isToBePublished) {
            echo "</b>";
        }
        echo "<br />";
        echo "<br />";
    }
}
