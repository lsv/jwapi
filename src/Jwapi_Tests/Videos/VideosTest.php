<?php
namespace Jwapi_Tests\Videos;

use Jwapi\Videos\Create;
use Jwapi\Videos\Delete;
use Jwapi\Videos\Lists;
use Jwapi\Videos\Show;
use Jwapi\Videos\Update;
use Jwapi_Tests\TestClass;

class VideosTest extends TestClass
{

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
            ->setTitle($this->getFiledownloadUrlName())
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
            'title' => $this->getFiledownloadUrlName(),
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
    }

    public function test_canUploadMovie()
    {
        $date = new \DateTime();

        $obj = new Create($this->getApiKey(), $this->getApiSecret());
        $obj
            ->setAuthor('Author')
            ->setDate($date)
            ->setDescription('desc')
            ->setTitle($this->getFileuploadUrlName())
            ->setVideoFile($this->getMp4VideoFile())
            ->setCustomParameters(array('custom1' => 'custom1'))
            ->addTag('testtag_1')
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
     * @expectedException \Exception
     */
    public function test_CreateVideoWithFalseCustomParametersKey()
    {
        $obj = new Create($this->getApiKey(), $this->getApiSecret());
        $obj->addCustomParameter('cust#om1', 'custom1');
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

    /**
     * @depends test_canCreateDownloadUrl
     */
    public function test_canDeleteDownloadUrl()
    {
        // Find movie
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setSearch($this->getFiledownloadUrlName());
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
        $obj->setSearch($this->getFiledownloadUrlName());
        $response = $obj->send()->json();
        $this->validateResponse($response, 'Could not "Recheck if deleted" from: test_DeleteCreatedFile');
        $this->assertArrayHasKey('videos', $response);
        $this->assertCount(0, $response['videos']);
    }

    /**
     * @depends test_canUploadMovie
     * @expectedException \InvalidArgumentException
     */
    public function test_cantUpdateMovieWithBothUrlAndDownload()
    {
        // Find movie
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setSearch($this->getFileuploadUrlName());
        $response = $obj->send()->json();

        $this->validateResponse($response, 'Could not "Find movie" from: test_DeleteUploadedFile');
        $this->assertArrayHasKey('videos', $response);
        $this->assertCount(1, $response['videos'], 'No file with name ' . $this->getFileuploadUrlName());
        $key = $response['videos'][0]['key'];

        // Update movie
        $obj = new Update($this->getApiKey(), $this->getApiSecret());
        $obj->setVideoKey($key);
        $obj->setDownloadUrl($this->getOgvVideoFileUrl());
        $obj->setVideoFile($this->getOgvVideoFile());
        $response = $obj->send()->json();
    }

    /**
     * @depends test_cantUpdateMovieWithBothUrlAndDownload
     */
    public function test_canDeleteUploadMovie()
    {
        // Find movie
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setSearch($this->getFileuploadUrlName());
        $response = $obj->send()->json();

        $this->validateResponse($response, 'Could not "Find movie" from: test_DeleteUploadedFile');
        $this->assertArrayHasKey('videos', $response);
        $this->assertCount(1, $response['videos'], 'No file with name ' . $this->getFileuploadUrlName());
        $key = $response['videos'][0]['key'];

        // Update movie
        $obj = new Update($this->getApiKey(), $this->getApiSecret());
        $obj->setVideoKey($key);
        $obj->setTitle($this->getuploadAfterUrlName());
        $response = $obj->send()->json();
        $this->validateResponse($response, 'Could not "Update movie" from: test_DeleteUploadedFile');

        // Find again
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setSearch($this->getuploadAfterUrlName());
        $response = $obj->send()->json();
        $this->validateResponse($response, 'Could not "Find again" from: test_DeleteUploadedFile');
        $this->assertCount(1, $response['videos'], 'No videos with title ' . $this->getuploadAfterUrlName());
        $key = $response['videos'][0]['key'];

        // Show video
        $obj = new Show($this->getApiKey(), $this->getApiSecret());
        $obj->setVideoKey($key);
        $response = $obj->send()->json();
        $this->validateResponse($response, 'Could not "Show video" from: test_DeleteUploadedFile');
        $this->assertArrayHasKey('video', $response);
        $this->assertArrayHasKey('mediatype', $response['video']);

        // Delete movie
        $deleter = new Delete($this->getApiKey(), $this->getApiSecret());
        $deleter->setVideoKey($key);
        $response = $deleter->send()->json();
        $this->validateResponse($response, 'Could not "Delete movie" from: test_DeleteUploadedFile');

        // Recheck if deleted
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setSearch($this->getuploadAfterUrlName());
        $response = $obj->send()->json();
        $this->validateResponse($response, 'Could not "Recheck if deleted" from: test_DeleteUploadedFile');
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('videos', $response);
        $this->assertEquals(Lists::STATUS_OK, $response['status']);
        $this->assertCount(0, $response['videos']);
    }

} 