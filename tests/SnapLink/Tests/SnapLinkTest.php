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
        $snapLink = new SnapLink('https://www.youtube.com/watch?v=dwpBHCZ9DBM');
        $parsed = $snapLink->getParsed();
        foreach ($parsed as $parserName => $link) {
            self::assertNotEmpty($link->getUrl());
            self::assertNotEmpty($link->getTitle());
            self::assertNotEmpty($link->getDescription());
            self::assertNotEmpty($link->getImage());
            self::assertNotEmpty($link->getEmbedCode());
            self::assertNotEmpty($parserName);
        }
        $parsedLink = current($parsed);
        self::assertInstanceOf('Sintezis\SnapLink\Model\VideoLink', $parsedLink);
    }

    public function testFacebook()
    {
        $snapLink = new SnapLink('https://www.facebook.com/vgdanas/posts/1608723339299866');
        $parsed = $snapLink->getParsed();
        foreach ($parsed as $parserName => $link) {
            self::assertNotEmpty($link->getUrl());
            self::assertNotEmpty($link->getTitle());
            self::assertNotEmpty($link->getDescription());
            self::assertNotEmpty($link->getImage());
            self::assertNotEmpty($parserName);
        }

        self::assertEquals('https://www.facebook.com/vgdanas/posts/1608723339299866', $snapLink->getUrl());
    }

    public function testSpotify()
    {
        $snapLink = new SnapLink('https://open.spotify.com/track/5ScJ1wvDx0yzGcUHa9buEu?si=76G--lVxTHi6W3OcBlgmVA');
        $parsed = $snapLink->getParsed();
        foreach ($parsed as $parserName => $link) {
            self::assertNotEmpty($link->getUrl());
            self::assertNotEmpty($link->getTitle());
            self::assertNotEmpty($link->getDescription());
            self::assertNotEmpty($link->getImage());
            self::assertNotEmpty($parserName);
        }

        self::assertEquals('https://open.spotify.com/track/5ScJ1wvDx0yzGcUHa9buEu?si=76G--lVxTHi6W3OcBlgmVA', $snapLink->getUrl());
    }

    public function testReddit()
    {
        $snapLink = new SnapLink('https://www.reddit.com/r/gaming/comments/k411lv/i_couldnt_be_more_proud_of_her_after_a_lot_of/');
        $parsed = $snapLink->getParsed();
        foreach ($parsed as $parserName => $link) {
            self::assertNotEmpty($link->getUrl());
            self::assertNotEmpty($link->getTitle());
            self::assertNotEmpty($link->getDescription());
            self::assertNotEmpty($link->getImage());
            self::assertNotEmpty($parserName);
        }

        self::assertEquals('https://www.reddit.com/r/gaming/comments/k411lv/i_couldnt_be_more_proud_of_her_after_a_lot_of/', $snapLink->getUrl());
    }

    public function testRandomSite()
    {
        $snapLink = new SnapLink('https://techcrunch.com/2020/12/15/what-to-expect-tomorrow-at-tc-sessions-space-2020/');
        $parsed = $snapLink->getParsed();
        foreach ($parsed as $parserName => $link) {
            self::assertNotEmpty($link->getUrl());
            self::assertNotEmpty($link->getTitle());
            self::assertNotEmpty($link->getDescription());
            self::assertNotEmpty($link->getImage());
            self::assertNotEmpty($parserName);
        }

        self::assertEquals('https://techcrunch.com/2020/12/15/what-to-expect-tomorrow-at-tc-sessions-space-2020/', $snapLink->getUrl());
    }

    public function testTwitter()
    {
        $snapLink = new SnapLink('https://twitter.com/NBA/status/1335644099739791363');
        $parsed = $snapLink->getParsed();
        foreach ($parsed as $parserName => $link) {
            self::assertNotEmpty($link->getUrl());
            self::assertNotEmpty($link->getTitle());
            self::assertNotEmpty($link->getDescription());
            self::assertNotEmpty($link->getImage());
            self::assertNotEmpty($parserName);
        }

        self::assertEquals('https://twitter.com/NBA/status/1335644099739791363', $snapLink->getUrl());
    }
}
