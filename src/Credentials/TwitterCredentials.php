<?php

namespace TwitterJunkieBot\Credentials;

use Monolog\Logger;

class TwitterCredentials
{
    const TWITTER_CREDENTIALS_FILE = '../config/twitter_credentials.json';

    private $consumerKey;
    private $consumerSecret;
    private $oAuthToken;
    private $oAuthSecret;

    public function __construct($file)
    {
        $this->loadCredentials($file);
    }

    /**
     * @param string $file
     * @throws \Exception
     */
    private function loadCredentials($file)
    {
        if (!file_exists($file)) {
            throw new \Exception('Credentials file not found: ' . $file);
        }

        $string = file_get_contents($file);
        $json = json_decode($string, true);

        if (is_null($json)) {
            throw new \Exception('Credentials file can not be decoded. Is is a valid json file?');
        }

        if (empty($json)
            || !isset($json['consumerKey'])
            || !isset($json['consumerSecret'])
            || !isset($json['oAuthToken'])
            || !isset($json['oAuthSecret'])
        ) {
            throw new \Exception('Error. Twitter credentials file has not necessary keys');
        }

        $this->consumerKey = $json['consumerKey'];
        $this->consumerSecret = $json['consumerSecret'];
        $this->oAuthToken = $json['oAuthToken'];
        $this->oAuthSecret = $json['oAuthSecret'];
    }

    public function getConsumerKey()
    {
        return $this->consumerKey;
    }

    public function getConsumerSecret()
    {
        return $this->consumerSecret;
    }

    public function getOAuthToken()
    {
        return $this->oAuthToken;
    }

    public function getOAuthSecret()
    {
        return $this->oAuthSecret;
    }
}
