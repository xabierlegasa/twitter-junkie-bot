<?php

use TwitterJunkieBot\Bot\TwitterBot;
use TwitterJunkieBot\Bot\TwitterClient;
use TwitterJunkieBot\Credentials\TwitterCredentials;
use TwitterJunkieBot\Feed\RandomTranslation;
use TwitterJunkieBot\Feed\TwitterFeedBasqueDictionary;

require "../vendor/autoload.php";

$twitterCredentials = new TwitterCredentials(TwitterCredentials::TWITTER_CREDENTIALS_FILE);
$twitterClient = new TwitterClient($twitterCredentials);
$randomTranslation = new RandomTranslation();
$twitterFeed = new TwitterFeedBasqueDictionary($randomTranslation);
$twitterBot = new TwitterBot($twitterClient, $twitterFeed);
$twitterBot->tweetRandomMessage();
