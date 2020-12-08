<?php

namespace Sintezis\SnapLink\Tests;

use Sintezis\SnapLink\SnapLink;

class PostGenerator extends \PHPUnit\Framework\TestCase
{
    public function testGeneratePostJson()
    {
        $snapLinks = [
            new SnapLink('https://www.youtube.com/watch?v=dwpBHCZ9DBM'),
            new SnapLink('https://twitter.com/NBA/status/1335644099739791363'),
            new SnapLink('https://open.spotify.com/track/5ScJ1wvDx0yzGcUHa9buEu?si=76G--lVxTHi6W3OcBlgmVA'),
            new SnapLink('https://www.youtube.com/watch?v=HrM-Xhb-kXM'),
            new SnapLink('https://twitter.com/ChampionsLeague/status/1336262396906778624?s=20'),
            new SnapLink('https://twitter.com/SouthamptonFC/status/1336053860083912705/photo/1'),
            new SnapLink('https://twitter.com/ChampionsLeague/status/1336233555274285059/photo/1'),
            new SnapLink('https://open.spotify.com/track/09hWjpT4VrR1FHeNFn52tQ?si=4r9yeZTzQne89SC7Il7Vxw'),
            new SnapLink('https://open.spotify.com/track/6WozspQ3YhGznIs4kXafnv?si=weieXcmERu2Z-OVoe-K3uQ'),
            new SnapLink('https://twitter.com/9GAG/status/1336159073931325442/photo/1'),
            new SnapLink('https://www.youtube.com/watch?v=Lq0fUa0vW_E'),
        ];
        $posts = [];
        foreach ($snapLinks as $snapLink) {
            $parsed = $snapLink->getParsed();
            foreach ($parsed as $link) {
                $post = [
                    'link' => $link->getUrl(),
                    'title' => $link->getTitle(),
                    'description' => $link->getDescription(),
                    'thumb_image_link' => $link->getImage(),
                    'root_url' => parse_url($link->getUrl())['host'],
                ];
            }
            $posts[] = $post;
        }

        file_put_contents(__DIR__ . '/posts.json', json_encode($posts));
        self::assertNotEmpty($posts);
    }
}
