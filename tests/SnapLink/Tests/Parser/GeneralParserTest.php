<?php

namespace Sintezis\SnapLink\Tests\Parser;

use Sintezis\SnapLink\Parser\GeneralParser;
use Sintezis\SnapLink\Model\Link;

class GeneralParserTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider urlProvider
     * @param string $url
     * @param bool $expectedResult
     */
    public function testIsValidParser($url, $expectedResult)
    {
        $linkMock = new Link();

        $parser = new GeneralParser();
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