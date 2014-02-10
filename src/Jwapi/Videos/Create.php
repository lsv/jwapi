<?php
namespace Jwapi\Videos;

use Jwapi\Api\Api;
use Symfony\Component\Finder\SplFileInfo;

use Jwapi\Traits;

class Create extends Api
{
    use Traits\Tags;
    use Traits\Fileupload;

    protected $url = '/videos/create';
    protected $fileupload = 'video';

    private $customParameters = array();

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->setGet('title', $title);
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->setGet('description', $description);
        return $this;
    }

    /**
     * @param string $author
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->setGet('author', $author);
        return $this;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDate(\DateTime $date)
    {
        $this->setGet('date', $date->getTimestamp());
        return $this;
    }

    /**
     * @param string $link
     * @return $this
     */
    public function setLink($link)
    {
        $this->setGet('link', $link);
        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setDownloadUrl($url)
    {
        $this->setGet('download_url', $url);
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addCustomParameter($key, $value)
    {
        $this->customParameters[$key] = $value;
        return $this;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setCustomParameters(array $parameters)
    {
        foreach($parameters as $k => $v) {
            $this->addCustomParameter($k, $v);
        }

        return $this;
    }

    /**
     * @param string $md5
     * @return $this
     */
    public function setMd5($md5)
    {
        $this->setGet('md5', $md5);
        return $this;
    }

    /**
     * @param boolean $resumeable
     * @return $this
     */
    public function isResumeable($resumeable)
    {
        $this->setGet('resumable', $this->setBoolean($resumeable));
        return $this;
    }

    /**
     * @param integer $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->setGet('size', (int)$size);
        return $this;
    }

    /**
     * @param SplFileInfo $file
     * @return $this
     */
    public function setVideoFile(SplFileInfo $file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @throws \Exception
     */
    protected function beforeRun()
    {
        if ($this->tags) {
            $this->setGet('tags', implode(',', $this->tags));
        }

        if ($this->customParameters) {
            foreach($this->customParameters as $k => $v) {
                $this->setGet('custom.' . $k, $v);
            }
        }

        if ($this->issetGet('download_url') && $this->file != '') {
            throw new \Exception('Create video: Both download url and video file is set');
        }

        if (!$this->issetGet('download_url') && $this->file == '') {
            throw new \Exception('Create video: Download url or video file is not set');
        }

    }

} 