<?php

namespace tests\Unit;

use TwitterJunkieBot\Bot\TwitterBot;
use TwitterJunkieBot\Bot\TwitterClient;
use TwitterJunkieBot\Feed\TwitterFeed;

class TwitterBotTests extends \PHPUnit_Framework_TestCase
{
    const TEST_STATUS_MESSAGE = 'hello world!';

    /** @var TwitterBot */
    private $sut;

    /** @var TwitterClient */
    private $twitterClientMock;

    /**
     * @var TwitterFeed
     */
    private $twitterFeedMock;

    public function setUp()
    {
        $this->twitterClientMock = $this->prophesize('TwitterJunkieBot\Bot\TwitterClient');
        $this->twitterFeedMock = $this->prophesize('TwitterJunkieBot\Feed\TwitterFeed');
        $this->sut = new TwitterBot(
            $this->twitterClientMock->reveal(),
            $this->twitterFeedMock->reveal()
        );
    }

    public function testTweetRandomMessageWhenIsCalledShouldPostAMessageToTwitter()
    {
        $this->ifTwitterFeedReturns(self::TEST_STATUS_MESSAGE);

        $this->twitterClientMock
            ->post("statuses/update", array("status" => self::TEST_STATUS_MESSAGE))
            ->shouldBeCalled();

        $this->sut->tweetRandomMessage();

        $this->assertTrue(true);
    }

    private function ifTwitterFeedReturns($statusMessage)
    {
        $this->twitterFeedMock->getStatusMessage()->shouldBeCalled()
            ->willReturn($statusMessage);
    }
}
