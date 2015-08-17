<?php

namespace tests\Unit;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;
use TwitterJunkieBot\Feed\RandomTranslation;

class RandomTranslationTest extends \PHPUnit_Framework_TestCase
{
    const TEST_FILENAME = 'euskara.json';
    const TEST_NONEXISTENT_FILENAME = 'euskara.json';
    const TEST_VALID_TRANSLATIONS_JSON = '{"translations":[{"source":"abendu","target":"diciembre"},{"source":"aberats","target":"rico, adinerado"}]}';
    const TEST_MALFORMED_TRANSLATIONS_JSON = 'this is an invalid json text';
    const TEST_MISSING_KEY_TRANSLATIONS_JSON = '{"translations":[{"THIS ITEM HAS NO source KEY":"abendu","target":"diciembre"},{"source":"aberats","target":"rico, adinerado"}]}';


    /** @var RandomTranslation */
    private $sut;

    public function setUp()
    {
        $this->sut = new RandomTranslation();
        vfsStreamWrapper::register();
    }

    public function tearDown()
    {
        $this->sut = null;
    }

    /**
     * Method: getEandomTranslation
     * When: file is ok
     * Should: return random translation
     */
    public function testGetRandomTranslationFileIsOkReturnRandomTranslation()
    {
        /** @var vfsStreamDirectory $rootDir */
        $rootDir = vfsStream::newDirectory('rootDir');
        vfsStreamWrapper::setRoot($rootDir);
        /** @var vfsStreamFile $file */
        $file = vfsStream::newFile(self::TEST_FILENAME);
        $file->open();
        $file->write(self::TEST_VALID_TRANSLATIONS_JSON);
        $rootDir->addChild($file);

        $translation = $this->sut->getRandomTranslation(
            vfsStream::url('rootDir' . DIRECTORY_SEPARATOR . self::TEST_FILENAME)
        );
        $this->assertTrue($translation === 'aberats: rico, adinerado' || $translation === 'abendu: diciembre');
    }

    /**
     * Method: getEandomTranslation
     * When: file is not found
     * Should: return random translation
     */
    public function testGetRandomTranslationFileIsNotFoundReturnRandomTranslation()
    {
        /** @var vfsStreamDirectory $rootDir */
        $rootDir = vfsStream::newDirectory('rootDir');
        vfsStreamWrapper::setRoot($rootDir);

        $this->setExpectedException(
            'Exception',
            'Error getting random translation from file: vfs://rootDir/' . self::TEST_FILENAME
        );
        $translation = $this->sut->getRandomTranslation(
            vfsStream::url('rootDir' . DIRECTORY_SEPARATOR . self::TEST_FILENAME)
        );
    }

    /**
     * Method: getEandomTranslation
     * When: json is corrupted
     * Should: throw exception
     */
    public function testGetRandomTranslationFileIsCorruptedThrowException()
    {
        /** @var vfsStreamDirectory $rootDir */
        $rootDir = vfsStream::newDirectory('rootDir');
        vfsStreamWrapper::setRoot($rootDir);
        /** @var vfsStreamFile $file */
        $file = vfsStream::newFile(self::TEST_FILENAME);
        $file->open();
        $file->write(self::TEST_MALFORMED_TRANSLATIONS_JSON);
        $rootDir->addChild($file);

        $this->setExpectedException(
            'Exception',
            'Error. Language file is not found or is invalid. File: vfs://rootDir/' . self::TEST_FILENAME
        );
        $translation = $this->sut->getRandomTranslation(
            vfsStream::url('rootDir' . DIRECTORY_SEPARATOR . self::TEST_FILENAME)
        );
    }

    /**
     * Method: getEandomTranslation
     * When: a translation is missing a key
     * Should: throw exception
     */
    public function testGetRandomTranslationFileIsMissingAKeyThrowException()
    {
        /** @var vfsStreamDirectory $rootDir */
        $rootDir = vfsStream::newDirectory('rootDir');
        vfsStreamWrapper::setRoot($rootDir);
        /** @var vfsStreamFile $file */
        $file = vfsStream::newFile(self::TEST_FILENAME);
        $file->open();
        $file->write(self::TEST_MISSING_KEY_TRANSLATIONS_JSON);
        $rootDir->addChild($file);

        $this->setExpectedException(
            'Exception',
            'Error. Language file is not found or is invalid. File: vfs://rootDir/' . self::TEST_FILENAME
        );
        $translation = $this->sut->getRandomTranslation(
            vfsStream::url('rootDir' . DIRECTORY_SEPARATOR . self::TEST_FILENAME)
        );
    }
}
