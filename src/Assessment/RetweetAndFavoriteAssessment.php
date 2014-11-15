<?php

namespace Flock\Assessment;


use Flock\FlockException;
use stdClass;

class RetweetAndFavoriteAssessment implements IAssessment {

    /**
     * Decides how to treat a tweet:
     *  Q: Where to publish?
     *  A: List of IDs where to publish.
     *
     * @param stdClass $tweet A tweet
     * @return int[] Array of account IDs where the tweet should be published
     * @throws FlockException
     */
    public function assess(stdClass $tweet) {
        if (!isset($tweet->retweet_count) || !isset($tweet->favorite_count)) {
            throw new FlockException('Tweet without retweet_count or favorite_count');
        }

        if ($tweet->retweet_count * 3 + $tweet->favorite_count > 50) {
            return [self::PROGRAMOVANI_CZ];
        } else {
            return [];
        }
    }
} 