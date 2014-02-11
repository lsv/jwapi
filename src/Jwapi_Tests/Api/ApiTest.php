<?php
namespace Jwapi_Tests\Api;

use Jwapi\Videos\Delete;
use Jwapi_Tests\TestClass;

class ApiTest extends TestClass
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_CanCheckForRequiredFields()
    {
        $class = new Delete($this->getApiKey(), $this->getApiSecret());
        $class->send();
    }

    /**
     * @expectedException \Exception
     */
    public function test_CanGetWrongApiKey()
    {
        $class = new Delete('foo', 'foo');
        $class->setVideoKey('foo');
        $class->send();
    }

    /**
     * @expectedException \Exception
     */
    public function test_CanCheckForNonsetApiKey()
    {
        $class = new Delete('', '');
        $class->setVideoKey('foo');
        $class->send();
    }

} 