SnapLink 

[![Build Status](https://travis-ci.org/Sintezis/SnapLink.svg?branch=master)](https://travis-ci.org/Sintezis/SnapLink)
===========

A PHP library to easily scrap link preview information from website (url).

## Installation

### composer

Run `composer install SnapLink`


SnapLink will be installed in vendor/sintezis/snap-link

In destination project include composer autoload file from vendor/autoload.php

## Usage

```php
use Sintezi\SnapLink\SnapLink;

$snapLink = new SnapLink('http://github.com');
$parsed = $snapLink->getParsed();
foreach ($parsed as $parserName => $link) {
    echo $parserName . PHP_EOL . PHP_EOL;

    echo $link->getUrl() . PHP_EOL;
    echo $link->getRealUrl() . PHP_EOL;
    echo $link->getTitle() . PHP_EOL;
    echo $link->getDescription() . PHP_EOL;
    echo $link->getImage() . PHP_EOL;
    print_r($link->getPictures());
}
```


**Output**

```
general

http://github.com
https://github.com/
GitHub · Build software better, together.
GitHub is the best place to build software together. Over 10.1 million people use GitHub to share code.
https://assets-cdn.github.com/images/modules/open_graph/github-octocat.png
Array
(
    [0] => https://assets-cdn.github.com/images/modules/site/home-ill-build.png?sn
    [1] => https://assets-cdn.github.com/images/modules/site/home-ill-work.png?sn
    [2] => https://assets-cdn.github.com/images/modules/site/home-ill-projects.png?sn
    [3] => https://assets-cdn.github.com/images/modules/site/home-ill-platform.png?sn
    [4] => https://assets-cdn.github.com/images/modules/site/org_example_nasa.png?sn
)
```

###Youtube example

```php
use Sintezi\SnapLink\SnapLink;
use Sintezi\SnapLink\Model\VideoLink;

$snapLink = new SnapLink('https://www.youtube.com/watch?v=8ZcmTl_1ER8');

$parsed = $linkPreview->getParsed();
foreach ($parsed as $parserName => $link) {
    echo $parserName . PHP_EOL . PHP_EOL;

    echo $link->getUrl() . PHP_EOL;
    echo $link->getRealUrl() . PHP_EOL;
    echo $link->getTitle() . PHP_EOL;
    echo $link->getDescription() . PHP_EOL;
    echo $link->getImage() . PHP_EOL;
    if ($link instanceof VideoLink) {
        echo $link->getVideoId() . PHP_EOL;
        echo $link->getEmbedCode() . PHP_EOL;
    }
}
```


**Output**

```
youtube

https://www.youtube.com/watch?v=8ZcmTl_1ER8
http://gdata.youtube.com/feeds/api/videos/8ZcmTl_1ER8?v=2&alt=jsonc
Epic sax guy 10 hours
I had to remove my original one so I reuploaded this with much better quality.
(If you want it sound like previous one, try setting quality to 240p)
Yeah, I know that video sucks compared to original but no can do :(
http://i1.ytimg.com/vi/8ZcmTl_1ER8/hqdefault.jpg
8ZcmTl_1ER8
<iframe id="ytplayer" type="text/html" width="640" height="390" src="http://www.youtube.com/embed/8ZcmTl_1ER8" frameborder="0"/>
```