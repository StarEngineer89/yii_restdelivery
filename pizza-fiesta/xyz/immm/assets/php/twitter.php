<?php
require_once('TwitterAPIExchange.php');

$settings = array(
    'oauth_access_token' => "1485322933-oo8YU1ZTz5E4Zt92hTTbCdJoZxIJIabghjnsPkX",
    'oauth_access_token_secret' => "RfXHN2OXMkBYp3IaEqrBmPhUYR2N61P8pyHf8QXqM",
    'consumer_key' => "Zr397FLlTFM4RVBsoLVgA",
    'consumer_secret' => "3Z2wNAG2vvunam2mfJATxnJcThnqw1qu02Xy8QlqFI"
);

$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=' . $_POST['account'] . '&count=3';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$tweets = json_decode($twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest());

$first = " active";

foreach( $tweets as $tweet ) {

    $tweet_text = $tweet->text;
    $tweet_text = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="http://$1" target="_blank">http://$1</a>', $tweet_text); //replace links
    $tweet_text = preg_replace('/@([a-z0-9_]+)/i', '<a href="http://twitter.com/$1" target="_blank">@$1</a>', $tweet_text); //replace users

    $return .= '<div class="item' . $first . '">' . $tweet_text . '</div>';
    $first = "";
}

echo $return;