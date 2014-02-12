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
        return 'http://web3.superliga.dk/fileadmin/TESTFILES/' . $file;
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

} 