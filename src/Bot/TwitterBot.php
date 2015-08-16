<?php

namespace TwitterJunkieBot\Bot;

use TwitterJunkieBot\Feed\TwitterFeed;

class TwitterBot
{
    /** @var TwitterClient */
    private $twitterClient;

    /** @var TwitterFeed */
    private $twitterFeed;

    /**
     * @param TwitterClient $twitterClient
     * @param TwitterFeed $twitterFeed
     */
    public function __construct(TwitterClient $twitterClient, TwitterFeed $twitterFeed)
    {
        $this->twitterClient = $twitterClient;
        $this->twitterFeed = $twitterFeed;
    }

    public function tweetRandomMessage()
    {
        $this->twitterClient->post('statuses/update', array('status' => $this->twitterFeed->getStatusMessage()));
    }
}
