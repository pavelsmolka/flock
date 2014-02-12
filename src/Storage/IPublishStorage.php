<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 2/12/14
 * Time: 9:48 PM
 */

namespace Flock\Storage;


interface IPublishStorage {

    public function toBePublished($accountId, $tweetId);

    public function getTweetId($accountId);

} 