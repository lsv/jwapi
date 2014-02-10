<?php


namespace Jwapi\Traits;


trait Tags
{

    protected $tags = array();

    /**
     * @param array $tags
     * @return $this
     */
    public function setTags(array $tags)
    {
        foreach($tags as $tag) {
            $this->addTag($tag);
        }
        return $this;
    }

    /**
     * @param string $tag
     * @return $this
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

}