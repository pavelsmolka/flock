<?php

namespace Flock\Assessment;


use stdClass;

class PavelAssessment implements IAssessment {

    /**
     * Decides how to treat a tweet:
     *  Q: Where to publish?
     *  A: List of IDs where to publish.
     *
     * @param stdClass $tweet A tweet
     * @return int[] Array of account IDs where the tweet should be published
     */
    public function assess(stdClass $tweet) {
        // TODO: Implement assess() method.
    }
} 