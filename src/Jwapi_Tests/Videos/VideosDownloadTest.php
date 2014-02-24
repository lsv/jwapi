<?php
namespace Jwapi_Tests\Videos;

use Jwapi\Videos\Create;
use Jwapi\Videos\Delete;
use Jwapi\Videos\Lists;
use Jwapi_Tests\TestClass;

class VideosDownloadTest extends TestClass
{

    private function getFileName()
    {
        return 'test_download_' . $this->getVersion();
    }

    public function test_canCreateDownloadUrl()
    {
        $date = new \DateTime();
        $videofile = file_get_contents($this->getMp4VideoFileUrl());

        $obj = new Create($this->getApiKey(), $this->getApiSecret());
        $obj
            ->setAuthor('Author')
            ->setDate($date)
            ->setDescription('desc')
            ->setLink('http://barfoo.com')
            ->setTitle($this->getFileName())
            ->setDownloadUrl($this->getMp4VideoFileUrl())
            ->setMd5(md5($videofile))
            ->isResumeable(true)
            ->setSize(strlen($videofile))
            ->addTag('testtag_1')
            ->setTags(array('testtag_2', 'testtag_3'))
        ;

        $response = $obj->send();
        $url = parse_url($response->getEffectiveUrl());
        $values = array(
            'author' => 'Author',
            'date' => $date->getTimestamp(),
            'description' => 'desc',
            'title' => $this->getFileName(),
            'tags' => 'testtag_1,testtag_2,testtag_3',
            'download_url' => urlencode($this->getMp4VideoFileUrl()),
            'link' => urlencode('http://barfoo.com'),
            'md5' => md5($videofile),
            'resumable' => 'True',
            'size' => strlen($videofile)
        );

        $this->checkUrlValues($url, $values);
        $this->checkUrl($obj, $url);
        $this->checkSignature($obj, $url);
        $this->validateResponse($response->json(), 'from: test_canCreateDownloadUrl');
    }

    /**
     * @depends test_canCreateDownloadUrl
     */
    public function test_canDeleteDownloadUrl()
    {
        // Find movie
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setSearch($this->getFileName());
        $response = $obj->send()->json();
        $this->validateResponse($response, 'Could not "Find movie" from: test_DeleteCreatedFile');
        $this->assertArrayHasKey('videos', $response);
        $this->assertCount(1, $response['videos']);
        $key = $response['videos'][0]['key'];

        // Delete movie
        $deleter = new Delete($this->getApiKey(), $this->getApiSecret());
        $deleter->setVideoKey($key);
        $response = $deleter->send()->json();
        $this->validateResponse($response, 'Could not "Delete movie" from: test_DeleteCreatedFile');

        // Recheck if deleted
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setSearch($this->getFileName());
        $response = $obj->send()->json();
        $this->validateResponse($response, 'Could not "Recheck if deleted" from: test_DeleteCreatedFile');
        $this->assertArrayHasKey('videos', $response);
        $this->assertCount(0, $response['videos']);
    }

} 