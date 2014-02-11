<?php
/**
 * This file is part of JW API.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license http://opensource.org/licenses/MIT
 * @author Martin Aarhof <martin.aarhof@gmail.com>
 */
namespace Jwapi\Videos\Thumbnails;

use Jwapi\Api\Api;
use Symfony\Component\Finder\SplFileInfo;
use Jwapi\Traits;

/**
 * Update a video’s thumbnail by either setting a frame from the video or uploading an image.
 * @package Jwapi\Videos\Thumbnails
 */
class Update extends Api
{
    use Traits\VideoKey;
    use Traits\Fileupload;

    /**
     * {@inherit}
     */
    protected $path = '/videos/thumbnails/update';

    /**
     * File upload key
     * @var string
     */
    protected $fileupload = 'thumbnail';

    /**
     * (optional)
     * Video frame position in seconds from which thumbnail should be generated. Seconds can be given as a whole number (e.g: 7) or with the fractions (e.g.: 7.42).
     *
     * @param float $position
     * @return Update
     */
    public function setPosition($position)
    {
        $this->setGet('position', (float)$position);
        return $this;
    }

    /**
     * (optional)
     * Index of the image in the thumbnail strip to use as a video thumbnail. Thumbnail index starts from 1.
     *
     * @param integer $index
     * @return Update
     */
    public function setThumbnailIndex($index)
    {
        $this->setGet('thumbnail_index', (int)$index);
        return $this;
    }

    /**
     * (optional)
     * Set the thumbnail file
     *
     * @param SplFileInfo $file
     * @return Update
     */
    public function setImageFile(SplFileInfo $file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * (optional)
     * Thumbnail file MD5 message digest. If supplied, it will be checked by the API.
     *
     * @param string $md5
     * @return Update
     */
    public function setMd5($md5)
    {
        $this->setGet('md5', $md5);
        return $this;
    }

    /**
     * (optional)
     * Thumbnail file size. If supplied, it will be checked by the API.
     *
     * @param integer $size
     * @return Update
     */
    public function setSize($size)
    {
        $this->setGet('size', (int)$size);
        return $this;
    }

    /**
     * {@inherit}
     * @throws \Exception
     */
    protected function beforeRun()
    {
        if (! $this->issetGet('position') && ! $this->file instanceof SplFileInfo) {
            throw new \Exception('Update thumbnail: Either file or position is set');
        }

        if ($this->issetGet('position') && $this->file instanceof SplFileInfo) {
            throw new \Exception('Update thumbnail: Both file and position is set');
        }
    }

} 