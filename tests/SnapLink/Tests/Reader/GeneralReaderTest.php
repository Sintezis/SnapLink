<?php

namespace Sintezis\SnapLink\Tests\Reader;

use Sintezis\SnapLink\Reader\GeneralReader;
use Sintezis\SnapLink\Model\Link;

class GeneralReaderTest extends \PHPUnit\Framework\TestCase
{
    public function testReadLink()
    {
        $responseMock = $this->createMock(
            'GuzzleHttp\Psr7\Response'
        );

        $responseMock->expects(self::once())
            ->method('getBody')
            ->will(self::returnValue('body'));
        $responseMock->expects(self::once())
            ->method('getHeader')
            ->will(self::returnValue(array('text/html; UTF-8')));

        $clientMock = $this->createMock('GuzzleHttp\Client');
        $clientMock->expects(self::once())
            ->method('request')
            ->will(self::returnValue($responseMock));

        $link = new Link();

        $reader = new GeneralReader();
        $reader->setClient($clientMock);
        $reader->setLink($link);

        $link = $reader->readLink();
        
        self::assertEquals('body', $link->getContent());
        self::assertEquals('text/html', $link->getContentType());
    }
}
