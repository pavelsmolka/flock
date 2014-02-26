<?php

namespace Flock\Assessment;

use Flock\IProcess;
use Flock\Storage\IPublishStorage;
use Flock\Storage\IUserBasedStorage;
use Flock\Storage\IProcessedStorage;

class AssessmentWorker implements IProcess {

    /** @var \Flock\Storage\IUserBasedStorage */
    protected $sourceStorage;

    /** @var \Flock\Storage\IPublishStorage */
    protected $resultStorage;
    
    /** @var \Flock\Storage\IProcessedStorage */
    protected $processedStorage;

    /** @var IAssessment */
    protected $assessment;

    public function __construct(IUserBasedStorage $sourceStorage, 
            IPublishStorage $resultStorage, 
            IProcessedStorage $processedStorage,  
            IAssessment $assessment) {
        
        $this->sourceStorage = $sourceStorage;
        $this->resultStorage = $resultStorage;
        $this->processedStorage = $processedStorage;
        $this->assessment = $assessment;
    }

    public function work() {

        // Get a tweet
        while (null !== ($tweet = $this->sourceStorage->getTweet())) {
            if($this->processedStorage->isStored($tweet->id)) {
               continue;
            }
            // Decide where to publish, using $this->assessment
            $accountsToPublish = $this->assessment->assess($tweet);

            // Save the tweet IDs accordingly
            foreach($accountsToPublish as $accountId) {
                $this->pushToPublishStorage($accountId, $tweet->id);
            }

        }
    }
    
    protected function pushToPublishStorage($accountId, $tweetId) {
        $success = $this->resultStorage->toBePublished($accountId, $tweetId);
        if($success > 0) {
            $this->pushToProcessedStorage($tweetId);
        }
    }
    
    protected function pushToProcessedStorage($tweetId) {
        $this->processedStorage->saveTweet($tweetId);
    }

} 