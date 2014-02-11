<?php
namespace Jwapi_Tests\Videos;

use Jwapi\Videos\Delete;
use Jwapi_Tests\TestClass;

class DeleteTest extends TestClass
{

    private $class = null;

    private function getDeleteClass()
    {
        if ($this->class === null) {
            return $this->class = new Delete($this->getApiKey(), $this->getApiSecret());
        }

        return $this->class;
    }

    public function test_CanDelete()
    {
        $url = parse_url(
            $this->getDeleteClass()
                ->setVideoKey('foobarvideo')
                ->send(false)
                ->getEffectiveUrl()
        );
        
        parse_str($url['query'], $query);

        $this->checkUrl($this->getDeleteClass(), $url);
        $this->assertEquals('foobarvideo', $query['video_key']);



    }

} 