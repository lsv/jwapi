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
            ->setVideoKey('foobarvideo');

        $url = parse_url($obj->send(false)->getEffectiveUrl());
        $values = array(
            'video_key' => 'foobarvideo'
        );
        $this->checkUrlValues($url, $values);

        $this->checkUrl($obj, $url);
        $this->checkMd5($obj, $url);

    }

} 