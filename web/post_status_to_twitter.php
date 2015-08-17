<?php

use TwitterJunkieBot\Bot\TwitterBot;
use TwitterJunkieBot\Bot\TwitterClient;
use TwitterJunkieBot\Credentials\TwitterCredentials;
use TwitterJunkieBot\Feed\RandomTranslation;
use TwitterJunkieBot\Feed\TwitterFeedBasqueDictionary;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require "../vendor/autoload.php";

try {
    date_default_timezone_set('Europe/Paris');

    $logger = new Logger('Twitter Junkie Bot');
    $logger->pushHandler(new StreamHandler('../logs/twitter-junkie-bot.log', Logger::INFO));

    $twitterCredentials = new TwitterCredentials(TwitterCredentials::TWITTER_CREDENTIALS_FILE);
    $twitterClient = new TwitterClient($twitterCredentials);
    $randomTranslation = new RandomTranslation();
    $twitterFeed = new TwitterFeedBasqueDictionary($randomTranslation);
    $twitterBot = new TwitterBot($twitterClient, $twitterFeed);
    $twitterBot->tweetRandomMessage();


} catch (\Exception $e) {
    $logger->addError('Error. Exception: ' . $e->getMessage());
    echo 'Error posting new status. Check the log for more details.';
    exit;
}


$logger->addInfo('Posted new status. ' . date('Y-m-d H:i:s'));
echo 'OK. New status posted.';
