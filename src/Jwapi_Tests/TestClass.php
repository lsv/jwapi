<?php
namespace Jwapi_Tests;

use Jwapi\Api\Api;

abstract class TestClass extends \PHPUnit_Framework_TestCase
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getApiKey()
    {
        return JWTEST_APIKEY;
    }

    public function getApiSecret()
    {
        return JWTEST_APISECRET;
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