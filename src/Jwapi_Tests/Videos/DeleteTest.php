<?php
namespace Jwapi_Tests\Videos;

use Jwapi\Videos\Delete;
use Jwapi_Tests\TestClass;

class DeleteTest extends TestClass
{

    public function test_CanCreateDeleteUrl()
    {
        $obj = new Delete($this->getApiKey(), $this->getApiSecret());
        $obj
            ->setVideoKey('rWXIecrY');

        $url = parse_url($obj->send(false)->getEffectiveUrl());
        $values = array(
            'video_key' => 'rWXIecrY'
        );
        $this->checkUrlValues($url, $values);

        $this->checkUrl($obj, $url);
        $this->checkSignature($obj, $url);

    }

} 