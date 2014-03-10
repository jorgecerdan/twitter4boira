<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>twitter</title>
</head>
<body>
<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "",
    'oauth_access_token_secret' => "",
    'consumer_key' => "BGM2V2uwvMmRhhDKbiUwQ",
    'consumer_secret' => "A0THQuj3aG8UGvtrlBldy2rtPSqrOKb0BqLfOg0nVI"
);

if (!defined('E_DEPRECATED')) define('E_DEPRECATED', 8192);
error_reporting(E_ALL | E_STRICT | E_DEPRECATED);


require_once 'lib/Twitter/Autolink.php';
require_once 'lib/Twitter/Extractor.php';
require_once 'lib/Twitter/HitHighlighter.php';



// Your specific requirements
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$requestMethod = 'GET';
$getfield = '?q=#'.$_GET['tagname'];

// Perform the request
$twitter = new TwitterAPIExchange($settings);


$response = $twitter->setGetfield($getfield)
                    ->buildOauth($url, $requestMethod)
                    ->performRequest();

$response = json_decode($response);


echo "<ul>";
foreach($response->statuses as $tweet)
{
    $img_profile = $tweet->user->profile_image_url;
    $screen_name = $tweet->user->screen_name;
    $text = $tweet->text;

    $html = Twitter_Autolink::create($text)
    ->setNoFollow(false)
    ->addLinks();
    echo "<li>".$html."</li>";

    //echo "<li><a href='http://twitter.com/".$screen_name."''><img src=".$img_profile." /></a>$text</li>";
    //parse_message($tweet);
}
echo "</ul>";




?>
</body>
</html>