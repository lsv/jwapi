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

} 