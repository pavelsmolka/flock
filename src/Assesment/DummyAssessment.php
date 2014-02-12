<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 2/12/14
 * Time: 9:44 PM
 */

namespace Flock\Assessment;


use Flock\Fetch\User;
use Flock\Storage\RedisPublishStorage;
use Flock\Storage\RedisUserBasedStorage;

class DummyAssessment {

    protected $sourceStorage;
    protected $resultStorage;

    const PROGRAMOVANI_CZ = 'programovaniCZ';
    const VARENI = 'vareni';

    public function __construct() {
        $this->sourceStorage = new RedisUserBasedStorage();
        $this->resultStorage = new RedisPublishStorage();
    }

    public function work() {
        foreach($this->getDummyRules() as $userName => $publishing) {
            $user = new User($userName); // TODO rework, rules should provide already created user objects
            while (null !== ($tweet = $this->sourceStorage->getTweet($user))) {
                if (isset($tweet->id)) {
                    foreach($publishing as $pub) {
                        $this->resultStorage->toBePublished($pub, $tweet->id);
                    }
                }
            }

        }
    }


    /**
     * TODO just temporary to get it working
     *
     * @return array
     */
    protected function getDummyRules() {
        return [
            'honzajavorek' => [self::PROGRAMOVANI_CZ],
            'geekovo' => [self::PROGRAMOVANI_CZ],
            'ostoweb' => [self::PROGRAMOVANI_CZ],
            'marek_jelen' => [self::PROGRAMOVANI_CZ],
            'cuketka' => [self::VARENI],
        ];
    }

} 