<?php
namespace Jwapi_Tests\Videos;

use Jwapi\Videos\Create;
use Jwapi_Tests\TestClass;

class VideosTest extends TestClass
{

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

} 