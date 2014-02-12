<?php
namespace Jwapi_Tests\Videos;

use Jwapi\Videos\Create;
use Jwapi_Tests\TestClass;

class CreateTest extends TestClass
{

    public function test_canCreateVideo()
    {
        $date = new \DateTime();

        $obj = new Create($this->getApiKey(), $this->getApiSecret());
        $obj
            ->setAuthor('Author')
            ->setDate($date)
            ->setDescription('desc')
            ->setTitle('test_canCreateVideo')
            ->setDownloadUrl('http://foobar.com')
            ->setLink('http://barfoo.com')
            ->setMd5('123')
            ->isResumeable(true)
            ->setSize(200)
            ->addTag('tag1')
            ->setTags(array('tag2', 'tag3'))
        ;

        $url = parse_url($obj->send()->getEffectiveUrl());
        $values = array(
            'author' => 'Author',
            'date' => $date->getTimestamp(),
            'description' => 'desc',
            'title' => 'test_canCreateVideo',
            'tags' => 'tag1,tag2,tag3',
            'download_url' => urlencode('http://foobar.com'),
            'link' => urlencode('http://barfoo.com'),
            'md5' => '123',
            'resumable' => 'True',
            'size' => 200
        );

        $this->checkUrlValues($url, $values);

        $this->checkUrl($obj, $url);
        $this->checkSignature($obj, $url);
    }

    public function test_canCreateCreateDownloadUrl()
    {
        $date = new \DateTime();

        $obj = new Create($this->getApiKey(), $this->getApiSecret());
        $obj
            ->setAuthor('Author')
            ->setDate($date)
            ->setDescription('desc')
            ->setTitle('Title_canCreateCreateDownloadUrl')
            ->setDownloadUrl($this->getMp4VideoFileUrl())
            ->addTag('TESTHEST')
        ;

        $response = $obj->send();

        $url = parse_url($response->getEffectiveUrl());
        $this->checkUrl($obj, $url);
        $this->checkSignature($obj, $url);
    }

    public function test_canCreateCreateUploadUrl()
    {
        $date = new \DateTime();

        $obj = new Create($this->getApiKey(), $this->getApiSecret());
        $obj
            ->setAuthor('Author')
            ->setDate($date)
            ->setDescription('desc')
            ->setTitle('test_canCreateCreateUploadUrl')
            ->setVideoFile($this->getMp4VideoFile())
            ->addTag('TESTHEST2')
        ;

        $response = $obj->send()->json();
        $this->assertArrayHasKey('status', $response);
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