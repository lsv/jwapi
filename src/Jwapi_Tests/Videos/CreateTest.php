<?php
namespace Jwapi_Tests\Videos;

use Jwapi\Videos\Create;
use Jwapi_Tests\TestClass;

class CreateTest extends TestClass
{

    public function test_canCreateCreateUrl()
    {
        $date = new \DateTime();

        $obj = new Create($this->getApiKey(), $this->getApiSecret());
        $obj
            ->setAuthor('Author')
            ->setDate($date)
            ->setDescription('desc')
            ->setTitle('Title')
            ->setDownloadUrl('http://foobar.com')
            ->setLink('http://barfoo.com')
            ->setMd5('123')
            ->isResumeable(true)
            ->setSize(200)
            ->addCustomParameter('custom1', 'custom1')
            ->setCustomParameters(array('custom2' => 'custom2', 'custom3' => 'custom3'))
            ->addTag('tag1')
            ->setTags(array('tag2', 'tag3'))
        ;

        $url = parse_url($obj->send(false)->getEffectiveUrl());
        $values = array(
            'author' => 'Author',
            'date' => $date->getTimestamp(),
            'description' => 'desc',
            'title' => 'Title',
            'tags' => 'tag1,tag2,tag3',
            'download_url' => urlencode('http://foobar.com'),
            'link' => urlencode('http://barfoo.com'),
            'custom_custom1' => 'custom1',
            'custom_custom2' => 'custom2',
            'custom_custom3' => 'custom3',
            'md5' => '123',
            'resumable' => 'True',
            'size' => 200
        );

        $this->checkUrlValues($url, $values);

        $this->checkUrl($obj, $url);
        $this->checkMd5($obj, $url);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_createVideoWithoutVideo()
    {
        $obj = new Create($this->getApiKey(), $this->getApiSecret());
        $obj->send(false);
    }

    /**
     * @expectedException \Exception
     */
    public function test_CreateVideoWithFalseCustomParameters()
    {
        $obj = new Create($this->getApiKey(), $this->getApiSecret());
        $obj->addCustomParameter('1custom1', 'custom1');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_CantSetBothDownloadAndVideo()
    {
        $obj = new Create($this->getApiKey(), $this->getApiSecret());
        $obj
            ->setDownloadUrl('http://foobar.com')
            ->setVideoFile($this->getMp4VideoFile())
            ->send()
        ;
    }

} 