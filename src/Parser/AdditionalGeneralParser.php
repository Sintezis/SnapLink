<?php

namespace Sintezis\SnapLink\Parser;

use Sintezis\SnapLink\Model\Link;
use Sintezis\SnapLink\Model\LinkInterface;
use Sintezis\SnapLink\Reader\GeneralReader;
use Sintezis\SnapLink\Reader\ReaderInterface;

/**
 * Class AdditionalGeneralParser
 */
class AdditionalGeneralParser implements ParserInterface
{
    /**
     * Url validation pattern taken from symfony UrlValidator
     */
    const PATTERN = '~^
            (http|https)://                                 # protocol
            (
                ([\pL\pN\pS-]+\.)+[\pL]+                   # a domain name
                    |                                     #  or
                \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}      # a IP address
                    |                                     #  or
                \[
                    (?:(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){6})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:::(?:(?:(?:[0-9a-f]{1,4})):){5})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){4})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,1}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){3})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,2}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){2})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,3}(?:(?:[0-9a-f]{1,4})))?::(?:(?:[0-9a-f]{1,4})):)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,4}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,5}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,6}(?:(?:[0-9a-f]{1,4})))?::))))
                \]  # a IPv6 address
            )
            (:[0-9]+)?                              # a port (optional)
            (/?|/\S+)                               # a /, nothing or a / with something
        $~ixu';

    /**
     * @var LinkInterface $link
     */
    private $link;

    /**
     * @var ReaderInterface $reader
     */
    private $reader;

    /**
     * @param ReaderInterface $reader
     * @param LinkInterface   $link
     */
    public function __construct(ReaderInterface $reader = null, LinkInterface $link = null)
    {
        if (null !== $reader) {
            $this->setReader($reader);
        } else {
            $this->setReader(new GeneralReader());
        }

        if (null !== $link) {
            $this->setLink($link);
        } else {
            $this->setLink(new Link());
        }
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return 'additional general';
    }

    /**
     * @inheritdoc
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @inheritdoc
     */
    public function setLink(LinkInterface $link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return ReaderInterface
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @param ReaderInterface $reader
     * @return $this
     */
    public function setReader(ReaderInterface $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isValidParser()
    {
        $isValid = false;

        $url = $this->getLink()->getUrl();

        if (is_string($url) && preg_match(static::PATTERN, $url)) {
            $isValid = true;
        }

        return $isValid;
    }

    /**
     * @inheritdoc
     */
    public function parseLink()
    {
        $this->readLink();

        $link = $this->getLink();

        if (!strncmp($link->getContentType(), 'text/', strlen('text/'))) {
            $htmlData = $this->parseHtml($link->getContent());

            $link->setTitle($htmlData['title'])
                ->setDescription($htmlData['description'])
                ->setImage($htmlData['image']);
        } elseif (!strncmp($link->getContentType(), 'image/', strlen('image/'))) {
            $link->setImage($link->getRealUrl());
        }

        return $link;
    }

    /**
     * Extract required data from html source
     * @param $html
     * @return array
     */
    protected function parseHtml($html)
    {
        $data = [
            'image' => '',
            'title' => '',
            'description' => '',
            'pictures' => [],
        ];

        $file = fopen($this->getLink()->getUrl(), 'r');

        $content = '';
        if(!$file) {
            while(!feof($file))
            {
                $content .= fgets($file,1024);
            }
        }

        $metaTags = array_merge(
            get_meta_tags($this->getLink()->getUrl()),
            $this->loadAdditionalOGMetaTags($this->getLink()->getUrl())
        );

        if (array_key_exists('og:title',$metaTags)) {
            $data['title'] = $metaTags['og:title'];
        } else if(array_key_exists('twitter:title',$metaTags)) {
            $data['title'] = $metaTags['twitter:title'];
        } else {
            $titlePattern = '/<title>(.+)<\/title>/i';
            preg_match_all($titlePattern, $content, $title, PREG_PATTERN_ORDER);

            if( !is_array($title[1]) ) {
                $data['title'] = $title[1];
            } else {
                if(count($title[1]) > 0) {
                    $data['title'] = $title[1][0];
                }
            }
        }
        
        if(array_key_exists('description',$metaTags)) {
            $data['description'] = $metaTags['description'];
        } else if(array_key_exists('og:description',$metaTags)) {
            $data['description'] = $metaTags['og:description'];
        } else if(array_key_exists('twitter:description',$metaTags)) {
            $data['description'] = $metaTags['twitter:description'];
        }

        $data['description'] = preg_replace( "/\r|\n/", "", $data['description']);

        if(array_key_exists('og:image',$metaTags)) {
            $data['image'] = $metaTags['og:image'];
        } else if(array_key_exists('og:image:src',$metaTags)) {
            $data['image'] = $metaTags['og:image:src'];
        } else if(array_key_exists('og:image:content',$metaTags)) {
            $data['image'] = $metaTags['og:image:content'];
        } else if(array_key_exists('twitter:image',$metaTags)) {
            $data['image'] = $metaTags['twitter:image'];
        } else if(array_key_exists('twitter:image:src',$metaTags)) {
            $data['image'] = $metaTags['twitter:image:src'];
        } else if(array_key_exists('twitter:image:content',$metaTags)) {
            $data['image'] = $metaTags['twitter:image:content'];
        } else {
            $imgPattern = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
            $images = '';
            preg_match_all($imgPattern,$content,$images,PREG_PATTERN_ORDER);

            $totalImages = count($images[1]);
            if($totalImages > 0) {
                $images = $images[1];
            }

            $data['pictures'] = $images;

            for($i=0; $i < $totalImages; $i++)
            {
                if($this->validImage($images[$i]))
                {
                    list($width,$height,$type,$attr) = getimagesize($images[$i]);
                    
                    if( $width > 400 )
                    {
                        $data['image'] = $images[$i];
                        break;
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Read link
     */
    private function readLink()
    {
        $reader = $this->getReader()->setLink($this->getLink());
        $this->setLink($reader->readLink());
    }

    public function loadAdditionalOGMetaTags($html) 
    {
        libxml_use_internal_errors(true);

        $doc = new \DomDocument();
        $doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);

        $xpath = new \DOMXPath($doc);

        $query = '//*/meta[starts-with(@property, \'og:\')]';

        $metas = $xpath->query($query);

        $data = [];
        foreach ($metas as $meta) {
            $property = $meta->getAttribute('property');
            $content = $meta->getAttribute('content');
            $data[$property] = $content;
        }

        return $data;
    }

    public function validImage($file) {
        if (filter_var($file, FILTER_VALIDATE_URL) === FALSE) {
            return false;
        }

        $size = getimagesize($file);
        return (strtolower(substr($size['mime'], 0, 5)) == 'image' ? true : false);  
    }
}