<?php
/**
 * This file is part of JW API.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license http://opensource.org/licenses/MIT
 * @author Martin Aarhof <martin.aarhof@gmail.com>
 * @package Jwapi
 */
namespace Jwapi\Videos;

use Jwapi\Api\Api;
use Jwapi\Api\Upload;
use Symfony\Component\Finder\SplFileInfo;
use Jwapi\Traits;

/**
 * Create a new video by sending metadata and either a download url or file upload
 * @package Jwapi\Videos
 */
class Create extends Api
{
    use Traits\Tags;
    use Traits\CustomParameters;
    use Traits\Fileupload;

    /**
     * {@inherit}
     */
    protected $path = '/videos/create';

    /**
     * File upload key
     * @var string
     */
    protected $fileupload = 'video';

    /**
     * (optional)
     * Title of the video.
     *
     * @param  string $title
     * @return Create
     */
    public function setTitle($title)
    {
        $this->setGet('title', $title);

        return $this;
    }

    /**
     * (optional)
     * Description of the video.
     *
     * @param  string $description
     * @return Create
     */
    public function setDescription($description)
    {
        $this->setGet('description', $description);

        return $this;
    }

    /**
     * (optional)
     * Author of the video.
     *
     * @param  string $author
     * @return Create
     */
    public function setAuthor($author)
    {
        $this->setGet('author', $author);

        return $this;
    }

    /**
     * (optional)
     * Video creation date.
     *
     * @param  \DateTime $date
     * @return Create
     */
    public function setDate(\DateTime $date)
    {
        $this->setGet('date', $date->getTimestamp());

        return $this;
    }

    /**
     * (optional)
     * The URL of the web page where this video is published.
     *
     * @param  string $link
     * @return Create
     */
    public function setLink($link)
    {
        $this->setGet('link', $link);

        return $this;
    }

    /**
     * (optional)
     * URL from where to fetch a video file. Video file will be downloaded and processed on the server using this URL.
     * ALERT: Only URLs with the http protocol are supported.
     *
     * @param  string $url
     * @return Create
     */
    public function setDownloadUrl($url)
    {
        $this->setGet('download_url', $url);

        return $this;
    }

    /**
     * (optional)
     * Video file MD5 message digest. If supplied and resumable option is set to False,
     * it will be compared with the MD5 digest calculated for the received video file.
     * Uploaded video will be rejected if MD5 message digests do not match.
     *
     * @param  string $md5
     * @return Create
     */
    public function setMd5($md5)
    {
        $this->setGet('md5', $md5);

        return $this;
    }

    /**
     * (optional)
     * Specifies if the video will be uploaded using resumable protocol:
     * True: Video will be uploaded using resumable protocol.
     * False: Video will be uploaded using non-resumable protocol.
     *
     * @param  boolean $resumeable
     * @return Create
     */
    public function isResumeable($resumeable)
    {
        $this->setGet('resumable', $this->setBoolean($resumeable));

        return $this;
    }

    /**
     * (optional)
     * Video file size. If supplied, it will be compared with the size of the received video file.
     * Uploaded video will be rejected if the sizes do not match.
     *
     * @param  integer $size
     * @return Create
     */
    public function setSize($size)
    {
        $this->setGet('size', (int) $size);

        return $this;
    }

    /**
     * (optional)
     * Set the video file which should be uploaded
     *
     * @param  SplFileInfo $file
     * @return Create
     */
    public function setVideoFile(SplFileInfo $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * {@inherit}
     * @throws \InvalidArgumentException
     */
    protected function beforeRun()
    {
        $this->beforeTags();
        $this->beforeCustomParameters();

        if ($this->issetGet('download_url') && $this->file != '') {
            throw new \InvalidArgumentException('Create video: Both download url and video file is set');
        }

        if (!$this->issetGet('download_url') && $this->file == '') {
            throw new \InvalidArgumentException('Create video: Download url or video file is not set');
        }

    }
}
