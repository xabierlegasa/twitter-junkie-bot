<?php

namespace tests\Unit;

use Prophecy\Argument;
use TwitterJunkieBot\Feed\RandomTranslation;
use TwitterJunkieBot\Feed\TwitterFeedBasqueDictionary;

class TwitterFeedBasqueDictionaryTest extends \PHPUnit_Framework_TestCase
{
    /** @var TwitterFeedBasqueDictionary */
    private $sut;

    /** @var  RandomTranslation */
    private $randomTranslationMock;

    public function setUp()
    {
        $this->randomTranslationMock = $this->prophesize('TwitterJunkieBot\Feed\RandomTranslation');

        $this->sut = new TwitterFeedBasqueDictionary($this->randomTranslationMock->reveal());
    }

    /**
     * Method: getStatusMessage
     * When: is called
     * Should: return randomTranslation correct method
     */
    public function testGetStatusMessageIsCalledReturnRandomTranslationCorrectMethod()
    {
        $this->randomTranslationMock->getRandomTranslation(Argument::any())
                                    ->shouldBeCalled()
                                    ->willReturn('kaixo: hola');

        $statusMessage = $this->sut->getStatusMessage();
        $this->assertEquals('kaixo: hola', $statusMessage);
    }

}
