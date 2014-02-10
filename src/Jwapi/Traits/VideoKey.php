<?php
namespace Jwapi\Traits;

trait VideoKey
{

    public function setVideoKey($key)
    {
        $this->setGet('video_key', $key);
        return $this;
    }

} 