<?php

namespace Flock\Assessment;

use stdClass;

/**
 * A simplified version of Honza's Assesment class
 *
 * Actually, this is an attempt to create atomized Assesment rules, which can
 * be combined later.
 */
class KeywordAssessment implements IAssessment {

    /** @var array */
    protected $peopleKeywords = [];

    public function __construct() {
        $this->peopleKeywords = [
            "marek_jelen" => ["openshift"],
            "geekovo" => ["nette", "php"],
            "honzajavorek" => ["api", "rest"],
        ];
    }

    /**
     * Decides how to treat a tweet:
     *  Q: Where to publish?
     *  A: List of IDs where to publish.
     *
     * @param stdClass $tweet A tweet
     * @return int[] Array of account IDs where the tweet should be published
     */
    public function assess(stdClass $tweet) {
        $tweetAuthor = $tweet->user->screen_name;

        if (isset($this->peopleKeywords[$tweetAuthor])) {
            foreach ($this->peopleKeywords[$tweetAuthor] as $keyword) {
                if (stripos($tweet->text, $keyword) !== false) {
                    return [self::PROGRAMOVANI_CZ]; // TODO we might need to support another account to RT to
                }
            }
        }

        return false;
    }
}