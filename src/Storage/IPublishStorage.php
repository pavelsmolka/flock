<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 2/12/14
 * Time: 9:48 PM
 */

namespace Flock\Storage;


interface IPublishStorage {

    /**
     * @param string $accountName
     * @param int $tweetId
     * @return int
     */
    public function toBePublished($accountName, $tweetId);

    /**
     * @param $accountName
     * @return int|null
     */
    public function getTweetId($accountName);

} 