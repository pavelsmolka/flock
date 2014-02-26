<?php

namespace Flock\Storage;

interface IProcessedStorage {
    
    /**
     * @return void
     */
    public function saveTweet($tweetId);
    
    
    /**
     * @return boolean
     */
    public function isStored($tweetId);
}
