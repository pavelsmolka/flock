<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 2/22/14
 * Time: 6:00 PM
 */

namespace Flock\Assessment;


use Flock\Fetch\User;
use Flock\IProcess;
use Flock\Storage\IPublishStorage;
use Flock\Storage\IUserBasedStorage;

class AssessmentWorker implements IProcess {

    /** @var \Flock\Storage\IUserBasedStorage */
    protected $sourceStorage;

    /** @var \Flock\Storage\IPublishStorage */
    protected $resultStorage;

    /** @var IAssessment */
    protected $assessment;

    public function __construct(IUserBasedStorage $sourceStorage, IPublishStorage $resultStorage, IAssessment $assessment) {
        $this->assessment = $assessment;
        $this->sourceStorage = $sourceStorage;
        $this->resultStorage = $resultStorage;
    }

    public function work() {

        // Get a tweet
        while (null !== ($tweet = $this->sourceStorage->getTweet())) {

            // Decide where to publish, using $this->assessment
            $accountsToPublish = $this->assessment->assess($tweet);

            // Save the tweet IDs accordingly
            foreach($accountsToPublish as $accountId) {
                $this->resultStorage->toBePublished($accountId, $tweet->id);
            }

        }
    }

} 