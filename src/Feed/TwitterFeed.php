<?php

namespace TwitterJunkieBot\Feed;

interface TwitterFeed
{
    /** Get a status message to be posted in twitter
     * @return string
     */
    public function getStatusMessage();
}