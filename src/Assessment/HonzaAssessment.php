<?php

namespace Flock\Assessment;

use stdClass;

class HonzaAssessment implements IAssessment {

    protected $users = [
        'honzajavorek' => [self::PROGRAMOVANI_CZ],
        'geekovo' => [self::PROGRAMOVANI_CZ],
        'ostoweb' => [self::PROGRAMOVANI_CZ],
        'marek_jelen' => [self::PROGRAMOVANI_CZ],
        'VolmutJ' => [self::PROGRAMOVANI_CZ],
        'pavelsmolka' => [self::PROGRAMOVANI_CZ],
        'cuketka' => [self::VARENI],
    ];

    private $ruleSet = [
        "default" => [
            "retweets" => 5, // soft and hard trheshold might be added in the future
            "favorites" => 3, // soft and hard trheshold might be added in the future
            "keywords" => [], //keywords might have its own treshhold in the future
            "operator" => "or",
        ],
        "accounts" => [
            "honzajavorek" => [
                "retweets" => 3,
                "favorites" => 2,
                "keywords" => [],
                "operator" => "or"
            ],
            "marek_jelen" => [
                "keywords" => ["openshift"]
            ],
            "geekovo" => [
                "keywords" => ["nette"],
                "operator" => "and"
            ],
            "ostoweb" => [
                "retweets" => 7,
                "favorites" => 5,
                "operator" => "and",
                "keywords" => [],
            ]
        ]
    ];

    public function assess(stdClass $tweet) {
        $rules = $this->ruleSet["accounts"][$tweet->user->screen_name];

        $isRetweetable = $this->applyRules(
                $tweet, $this->ruleSet["accounts"][$tweet->user->screen_name]
        );

        if ($isRetweetable) {
            if (isset($this->users[$tweet->user->screen_name])) {
                return $this->users[$tweet->user->screen_name];
            }
        } else {
            return [];
        }
    }

    /**
     * Decides whether tweet fullfils rules for being published.
     * Algorithm checks whether favorites and/or retweets rules are fulfilled
     * (i.e. tweet has enough tweets / retweets) tweet is published.
     * If tweet contains keyword specified in ruleSet it is also published.
     */
    private function applyRules($tweet, $rules) {
        $normalizedRules = $this->normalizeRules($rules);
        $operator = $normalizedRules["operator"];
        $retweets = $tweet->retweet_count;
        $favorites = $tweet->favorite_count;

        if ($this->expressOperators($normalizedRules, $retweets, $favorites)) {
            return true;
        } else {
            foreach ($normalizedRules["keywords"] as $keyword) {

                if (stripos($tweet->text, $keyword) != false) {
                    return true;
                }
            }

            return false;
        }
    }

    /**
     * Ruleset might not contain all rules (convention over configuration)
     * This function completes rules for user account from default 
     * if they are missing.
     */
    private function normalizeRules($rules) {
        $resultRules = $rules;
        if (!isset($rules["retweets"])) {
            $resultRules["retweets"] = $this->ruleSet["default"]["retweets"];
        }
        if (!isset($rules["favorites"])) {
            $resultRules["favorites"] = $this->ruleSet["default"]["favorites"];
        }
        if (!isset($rules["keywords"])) {
            $resultRules["keywords"] = $this->ruleSet["default"]["keywords"];
        }
        if (!isset($rules["operator"])) {
            $resultRules["operator"] = $this->ruleSet["default"]["operator"];
        }

        return $resultRules;
    }

    private function expressOperators($rules, $retweets, $favorites) {
        switch ($rules["operator"]) {
            case "and":
                return $this->tweetsAndFavorites($retweets, $favorites, $rules["retweets"], $rules["favorites"]);
                break;
            case "or":
                return $this->tweetsOrFavorites($retweets, $favorites, $rules["retweets"], $rules["favorites"]);
                break;
        }
    }

    private function tweetsAndFavorites($retweets, $favorites, $retweetsTreshold, $favoritesTreshold) {
        if ($retweets >= $retweetsTreshold && $favorites >= $favoritesTreshold) {
            return true;
        } else {
            return false;
        }
    }

    private function tweetsOrFavorites($retweets, $favorites, $retweetsTreshold, $favoritesTreshold) {
        if ($retweets >= $retweetsTreshold || $favorites >= $favoritesTreshold) {
            return true;
        } else {
            return false;
        }
    }

}
