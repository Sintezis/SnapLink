<?php

namespace Sintezis\SnapLink\Tests\Parser;

use Sintezis\SnapLink\Parser\AdditionalGeneralParser;
use Sintezis\SnapLink\Model\Link;

class AdditionalGeneralParserTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider urlProvider
     * @param string $url
     * @param bool $expectedResult
     */
    public function testIsValidParser($url, $expectedResult)
    {
        $linkMock = new Link();

        $parser = new AdditionalGeneralParser();
        $parser->setLink($linkMock->setUrl($url));
        self::assertEquals($parser->isValidParser(), $expectedResult);
    }

    /**
     * @return array
     */
    public function urlProvider()
    {
        return [
            ['http://github.com', true],
            ['http://trololo', false],
            ['github.com', false]
        ];
    }
}