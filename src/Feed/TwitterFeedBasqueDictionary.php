<?php

namespace TwitterJunkieBot\Feed;

class TwitterFeedBasqueDictionary implements TwitterFeed
{
    const BASQUE_DICTIONARY_FILE = '../../app/Dictionary/euskara.json';

    /** RandomTranslation */
    private $randomTranslation;

    public function __construct(RandomTranslation $randomTranslation)
    {
        $this->randomTranslation = $randomTranslation;
    }

    public function getStatusMessage()
    {
        $completeFileName = dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . self::BASQUE_DICTIONARY_FILE;
        return $this->randomTranslation->getRandomTranslation($completeFileName);
    }
}
