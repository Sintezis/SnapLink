<?php

namespace Sintezis\SnapLink\Tests;

use Sintezis\SnapLink\SnapLink;

class SnapLinkTest extends \PHPUnit\Framework\TestCase
{
    public function testAddDefaultParsers()
    {
        $snapLink = new SnapLink();
        $snapLink->getParsed();

        self::assertArrayHasKey('general', $snapLink->getParsers());
    }

    public function testAddParser()
    {
        $generalParserMock = $this->createMock('Sintezis\SnapLink\Parser\GeneralParser');
        $youtubeParserMock = $this->createMock('Sintezis\SnapLink\Parser\YoutubeParser');

        $snapLink = new SnapLink();

        // check if parser is added to the list
        $snapLink->addParser($generalParserMock);
        $parsers = $snapLink->getParsers();

        self::assertContains($generalParserMock, $parsers);

        // check if parser added to the beginning of the list
        $snapLink->addParser($youtubeParserMock);
        $parsers = $snapLink->getParsers();

        self::assertContains($youtubeParserMock, $parsers);

        return $snapLink;
    }

    public function testGetParsed()
    {
        $linkMock = $this->createMock('Sintezis\SnapLink\Model\Link');

        $generalParserMock = $this->createMock('Sintezis\SnapLink\Parser\GeneralParser');
        $generalParserMock->expects(self::once())
            ->method('getLink')
            ->will(self::returnValue($linkMock));
        $generalParserMock->expects(self::once())
            ->method('isValidParser')
            ->will(self::returnValue(true));
        $generalParserMock->expects(self::once())
            ->method('__toString')
            ->will(self::returnValue('general'));
        $generalParserMock->expects(self::once())
            ->method('parseLink')
            ->will(self::returnValue($linkMock));

        $snapLink = new SnapLink();
        $snapLink->setPropagation(false);
        $snapLink->addParser($generalParserMock);
        $parsed = $snapLink->getParsed();

        self::assertArrayHasKey('general', $parsed);
    }

    /**
     * @depends testAddParser
     */
    public function testRemoveParser(SnapLink $snapLink)
    {
        $snapLink->removeParser('general');
        $parsers = $snapLink->getParsers();
        self::assertNotContains('general', $parsers);
    }

    public function testSetUrl()
    {
        $snapLink = new SnapLink('http://github.com');
        self::assertEquals('http://github.com', $snapLink->getUrl());
    }

    public function testYoutube()
    {
        $snapLink = new SnapLink('https://www.youtube.com/watch?v=C0DPdy98e4c');
        $parsedLink = current($snapLink->getParsed());
        self::assertInstanceOf('Sintezis\SnapLink\Model\VideoLink', $parsedLink);
    }
}