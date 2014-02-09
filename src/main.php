<?php

require_once "../vendor/autoload.php";

const HTML_NEW_LINE = "<br />";
const CONFIG_FILE = '../config.ini';

$settings = parse_ini_file(CONFIG_FILE);

if (!is_array($settings)) {
	echo "Do you have your '" . CONFIG_FILE . "' created properly?";
	echo HTML_NEW_LINE;
	echo "Humbly dying...";
	exit;
}

// Settings has to be an associative array, config may look like this:
// oauth_access_token = ...
// oauth_access_token_secret = ...
// consumer_key = ...
// consumer_secret = ...

$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$requestMethod = 'GET';

// I am afraid the alphabetical order might matter, because of oAuth
$getField = '?screen_name=VolmutJ';

try {
	$api = new TwitterAPIExchange($settings);

	// Fields must be set first, in order for oAuth to be able to calculate the signature
	$jsonResult = $api
	    ->setGetfield($getField)
	    ->buildOauth($url, $requestMethod)
	    ->performRequest();

} catch(Exception $e) {
	echo $e->getMessage();
	exit;
}

// Enjoy the happiness
$result = json_decode($jsonResult);
echo $jsonResult;
