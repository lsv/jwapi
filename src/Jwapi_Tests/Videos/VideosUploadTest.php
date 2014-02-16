<?php
namespace Jwapi_Tests\Videos;

use Jwapi\Videos\Create;
use Jwapi\Videos\Delete;
use Jwapi\Videos\Lists;
use Jwapi\Videos\Show;
use Jwapi\Videos\Update;
use Jwapi_Tests\TestClass;

class VideosUploadTest extends TestClass
{

    private function getFileName()
    {
        return 'test_upload_' . $this->getVersion();
    }

    private function getFileNameAfterUpdate()
    {
        return 'test_update_' . $this->getVersion();
    }

    public function test_canUploadMovie()
    {
        $date = new \DateTime();

        $obj = new Create($this->getApiKey(), $this->getApiSecret());
        $obj
            ->setAuthor('Author')
            ->setDate($date)
            ->setDescription('desc')
            ->setTitle($this->getFileName())
            ->setVideoFile($this->getMp4VideoFile())
            ->setCustomParameters(array('custom1' => 'custom1'))
            ->addTag('testtag_1')
        ;

        $response = $obj->send()->json();
        $this->validateResponse($response, 'from: test_canUploadMovie');
    }

    /**
     * @depends test_canUploadMovie
     * @expectedException \InvalidArgumentException
     */
    public function test_cantUpdateMovieWithBothUrlAndDownload()
    {
        // Find movie
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setSearch($this->getFileName());
        $response = $obj->send()->json();

        $this->validateResponse($response, 'Could not "Find movie" from: test_cantUpdateMovieWithBothUrlAndDownload');
        $this->assertArrayHasKey('videos', $response);
        $this->assertCount(1, $response['videos'], 'No file with name ' . $this->getFileName() . "\n" . print_r($response, true));
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
        $obj->setSearch($this->getFileName());
        $response = $obj->send()->json();

        $this->validateResponse($response, 'Could not "Find movie" from: test_DeleteUploadedFile');
        $this->assertArrayHasKey('videos', $response);
        $this->assertCount(1, $response['videos'], 'No file with name ' . $this->getFileName());
        $key = $response['videos'][0]['key'];

        // Update movie
        $obj = new Update($this->getApiKey(), $this->getApiSecret());
        $obj->setVideoKey($key);
        $obj->setTitle($this->getFileNameAfterUpdate());
        $response = $obj->send()->json();
        $this->validateResponse($response, 'Could not "Update movie" from: test_DeleteUploadedFile');

        // Find again
        $obj = new Lists($this->getApiKey(), $this->getApiSecret());
        $obj->setSearch($this->getFileNameAfterUpdate());
        $response = $obj->send()->json();
        $this->validateResponse($response, 'Could not "Find again" from: test_DeleteUploadedFile');
        $this->assertCount(1, $response['videos'], 'No videos with title ' . $this->getFileNameAfterUpdate());
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
        $obj->setSearch($this->getFileNameAfterUpdate());
        $response = $obj->send()->json();
        $this->validateResponse($response, 'Could not "Recheck if deleted" from: test_DeleteUploadedFile');
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('videos', $response);
        $this->assertEquals(Lists::STATUS_OK, $response['status']);
        $this->assertCount(0, $response['videos']);
    }

} 