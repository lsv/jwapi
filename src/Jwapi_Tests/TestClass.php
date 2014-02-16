<?php
namespace Jwapi_Tests;

use Jwapi\Api\Api;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

abstract class TestClass extends \PHPUnit_Framework_TestCase
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function getFiledownloadUrlName()
    {
        return 'test_download_' . $this->getVersion();
    }

    protected function getFileuploadUrlName()
    {
        return 'test_upload_' . $this->getVersion();
    }

    protected function getuploadAfterUrlName()
    {
        return 'test_updated_' . $this->getVersion();
    }

    private function getVersion()
    {
        return PHP_MAJOR_VERSION . PHP_MINOR_VERSION . PHP_RELEASE_VERSION;
    }

    protected function getApiKey()
    {
        return JWTEST_APIKEY;
    }

    protected function getApiSecret()
    {
        return JWTEST_APISECRET;
    }

    protected function getMp4VideoFile()
    {
        return $this->getFile('mp4test.mp4');
    }

    protected function getMp4VideoFileUrl()
    {
        return $this->getFileUrl('mp4test.mp4');
    }

    protected function getOgvVideoFile()
    {
        return $this->getFile('ogvtest.ogv');
    }

    protected function getOgvVideoFileUrl()
    {
        return $this->getFileUrl('ogvtest.ogv');
    }

    protected function getPngThumbnail()
    {
        return $this->getFile('pngthumb.png');
    }

    protected function getPngThumbnailUrl()
    {
        return $this->getFileUrl('pngthumb.png');
    }

    protected function getJpgThumbnail()
    {
        return $this->getFile('jpgthumb.jpg');
    }

    protected function getJpgThumbnailUrl()
    {
        return $this->getFileUrl('jpgthumb.jpg');
    }

    protected function getCaptionFile()
    {
        return $this->getFile('caption.srt');
    }

    protected function getCaptionFileUrl()
    {
        return $this->getFileUrl('caption.srt');
    }

    private function getFileUrl($file)
    {
        return 'http://home.aarhof.eu/jwapi-test/' . $file;
    }

    /**
     * @param $file
     * @return SplFileInfo
     * @throws \Exception
     */
    private function getFile($file)
    {
        $finder = new Finder();
        $files = $finder->files()->in(__DIR__ . '/testfiles')->name($file);
        foreach($files as $file) {
            return $file;
        }

        throw new \Exception('Could not find testfile: ' . $file);

    }

    protected function checkUrl(Api $class, $url)
    {
        $this->assertEquals(($class->getHttps() ? 'https' : 'http'), $url['scheme']);
        $this->assertEquals($class->getApiUrl(), $url['host']);
        $this->assertEquals($class->getPath(), $url['path']);
    }

    protected function checkSignature(Api $class, $url)
    {
        parse_str($url['query'], $query);
        ksort($query);

        $signature = array();
        foreach($query as $key => $val) {
            if ($key == 'api_signature') {
                continue;
            }
            $signature[] = $key . '=' . $val;
        }

        $this->assertEquals($query['api_signature'], sha1(implode('&', $signature) . $this->getApiSecret()), 'Wrong signature code');

    }

    protected function checkUrlValues($url, $values)
    {
        parse_str($url['query'], $query);
        foreach($values as $key => $val) {
            $this->assertArrayHasKey($key, $query);
            $this->assertEquals($query[$key], $val);
        }
    }

    protected function validateResponse($response, $msg)
    {
        if (is_array($response)) {
            $this->assertArrayHasKey('status', $response, $msg . "\n" . print_r($response, true));
            $this->assertEquals(Api::STATUS_OK, $response['status'], $msg . "\n" . $response['status']);
        } else {
            $this->assertFalse(true, 'Response is not a array:' . "\n\n" . $response . "\n\n" . $msg);
        }
    }

} 