<?php
namespace Jwapi\Videos\Thumbnails;

use Jwapi\Api\Api;
use Symfony\Component\Finder\SplFileInfo;
use Jwapi\Traits;

class Update extends Api
{
    use Traits\VideoKey;
    use Traits\Fileupload;

    protected $url = '/videos/thumbnails/update';
    protected $fileupload = 'thumbnail';

    /**
     * @param float $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->setGet('position', (float)$position);
        return $this;
    }

    /**
     * @param integer $index
     * @return $this
     */
    public function setThumbnailIndex($index)
    {
        $this->setGet('thumbnail_index', (int)$index);
        return $this;
    }

    public function setImageFile(SplFileInfo $file)
    {
        $this->file = $file;
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
     * @param integer $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->setGet('size', (int)$size);
        return $this;
    }

    public function beforeRun()
    {
        if (! $this->issetGet('position') && ! $this->file instanceof SplFileInfo) {
            throw new \Exception('Update thumbnail: Either file or position is set');
        }

        if ($this->issetGet('position') && $this->file instanceof SplFileInfo) {
            throw new \Exception('Update thumbnail: Both file and position is set');
        }
    }

} 