<?php

namespace TwitterJunkieBot\Bot;

use Abraham\TwitterOAuth\TwitterOAuth;
use TwitterJunkieBot\Credentials\TwitterCredentials;

/**
 * This class wraps TwitterOAuth class
 */
class TwitterClient
{
    /** @var TwitterCredentials */
    private $twitterCredentials;

    /**
     * @var TwitterOAuth
     */
    private $twitterOAuth;

    /**
     * @param TwitterCredentials $twitterCredentials
     */
    public function __construct(TwitterCredentials $twitterCredentials)
    {
        $this->twitterCredentials = $twitterCredentials;

        $this->twitterOAuth = new TwitterOAuth(
            $twitterCredentials->getConsumerKey(),
            $twitterCredentials->getConsumerSecret(),
            $twitterCredentials->getOAuthToken(),
            $twitterCredentials->getOAuthSecret()
        );
        $this->twitterOAuth->setTimeouts(10, 15);
    }

    /**
     * Make POST requests to the API.
     *
     * @param string $path
     * @param array  $parameters
     *
     * @return array|object
     */
    public function post($path, array $parameters = array())
    {
        return $this->twitterOAuth->post($path, $parameters);
    }
}
