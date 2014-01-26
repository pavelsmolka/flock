<?php

require_once "../vendor/autoload.php";

$settings = parse_ini_file('../config.ini');

// Settings has to be an associative array, config may look like this:
// oauth_access_token = ...
// oauth_access_token_secret = ...
// consumer_key = ...
// consumer_secret = ...

$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$requestMethod = 'GET';

// I am afraid the alphabetical order might matter, because of oAuth
$getField = '?screen_name=VolmutJ';

$api = new TwitterAPIExchange($settings);

// Fields must be set first, in order for oAuth to be able to calculate the signature
$jsonResult = $api
    ->setGetfield($getField)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

// Enjoy the happiness
$result = json_decode($jsonResult);
echo $jsonResult;
//var_dump($result);
