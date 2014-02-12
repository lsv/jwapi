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

    protected function getOgvVideoFile()
    {
        return $this->getFile('ogvtest.ogv');
    }

    protected function getPngThumbnail()
    {
        return $this->getFile('pngthumb.png');
    }

    protected function getJpgThumbnail()
    {
        return $this->getFile('jpgthumb.jpg');
    }

    protected function getCaptionFile()
    {
        return $this->getFile('caption.srt');
    }

    /**
     * @param $file
     * @return SplFileInfo
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

    protected function checkMd5(Api $class, $url)
    {
        parse_str($url['query'], $query);
        ksort($query);

        $signature = '';
        foreach($query as $key => $val) {
            if ($key == 'api_signature') continue;
            $signature .= $val;
        }

        $this->assertEquals($query['api_signature'], sha1($signature . $this->getApiSecret()));

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