<?php

namespace tests\Unit;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use org\bovigo\vfs\vfsStreamWrapper;
use TwitterJunkieBot\Credentials\TwitterCredentials;


class TwitterCredentialsTest extends \PHPUnit_Framework_TestCase
{
    const TEST_ROOT_DIR = 'rootDir';
    const TEST_TWITTER_CREDENTIALS_FILE = 'twitterCredentials.json';
    const TEST_VALID_CREDENTIALS_JSON = '{"consumerKey": "consumerKeyTest", "consumerSecret" : "consumerSecretTest", "oAuthToken" : "oAuthTokenTest", "oAuthSecret" : "oAuthSecretTest"}';

    /** @var TwitterCredentials */
    private $sut;

    /**
     * Method: construct
     * When: credentials file is not found
     * Should: throw an exception
     */
    public function testConstructWhenCredentialsFileDoesNotExistShouldThrowAnException()
    {
        vfsStreamWrapper::register();
        /** @var vfsStreamDirectory $rootDir */
        $rootDir = vfsStream::newDirectory('rootDir');
        vfsStreamWrapper::setRoot($rootDir);

        $this->setExpectedException('Exception', 'Credentials file not found: vfs://rootDir/' . self::TEST_TWITTER_CREDENTIALS_FILE);
        $this->sut = new TwitterCredentials(vfsStream::url('rootDir' . DIRECTORY_SEPARATOR . self::TEST_TWITTER_CREDENTIALS_FILE));
    }

    /**
     * Method: construct
     * When: credentials file is not valid JSON
     * Should: throw an exception
     */
    public function testConstructCredentialsFileIsNotValidJsonThrowAnException()
    {
        vfsStreamWrapper::register();
        /** @var vfsStreamDirectory $rootDir */
        $rootDir = vfsStream::newDirectory('rootDir');
        vfsStreamWrapper::setRoot($rootDir);
        /** @var vfsStreamFile $file */
        $file = vfsStream::newFile(self::TEST_TWITTER_CREDENTIALS_FILE);
        $file->open();
        $file->write('{"foo": this is an invalid json file! "bar"}');
        $rootDir->addChild($file);

        $this->setExpectedException('Exception', 'Credentials file can not be decoded. Is is a valid json file?');
        $this->sut = new TwitterCredentials(vfsStream::url('rootDir' . DIRECTORY_SEPARATOR . self::TEST_TWITTER_CREDENTIALS_FILE));
    }

    /**
     * Method: construct
     * When: credentials file is missing a key
     * Should: throw an exception
     */
    public function testConstructCredentialsFileIsMissingAKeyThrowException()
    {
        vfsStreamWrapper::register();
        /** @var vfsStreamDirectory $rootDir */
        $rootDir = vfsStream::newDirectory('rootDir');
        vfsStreamWrapper::setRoot($rootDir);
        /** @var vfsStreamFile $file */
        $file = vfsStream::newFile(self::TEST_TWITTER_CREDENTIALS_FILE);
        $file->open();
        $file->write('{"foo": "bar"}');
        $rootDir->addChild($file);

        $this->setExpectedException('Exception', 'Error. Twitter credentials file has not necessary keys');
        $this->sut = new TwitterCredentials(vfsStream::url('rootDir' . DIRECTORY_SEPARATOR . self::TEST_TWITTER_CREDENTIALS_FILE));
    }

    /**
     * Method: construct
     * When: credentials file is ok
     * Should: set correct credentials from Json
     */
    public function testConstructCredentialsFileIsOkSetCorrectCredentialsFromJson()
    {
        vfsStreamWrapper::register();
        /** @var vfsStreamDirectory $rootDir */
        $rootDir = vfsStream::newDirectory('rootDir');
        vfsStreamWrapper::setRoot($rootDir);
        /** @var vfsStreamFile $file */
        $file = vfsStream::newFile(self::TEST_TWITTER_CREDENTIALS_FILE);
        $file->open();
        $file->write(self::TEST_VALID_CREDENTIALS_JSON);
        $rootDir->addChild($file);

        $this->sut = new TwitterCredentials(vfsStream::url('rootDir' . DIRECTORY_SEPARATOR . self::TEST_TWITTER_CREDENTIALS_FILE));

        $this->assertEquals('consumerKeyTest', $this->sut->getConsumerKey());
        $this->assertEquals('consumerSecretTest', $this->sut->getConsumerSecret());
        $this->assertEquals('oAuthTokenTest', $this->sut->getOAuthToken());
        $this->assertEquals('oAuthSecretTest', $this->sut->getOAuthSecret());
    }
}
