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
namespace Jwapi\Videos;

use Jwapi\Traits;

/**
 * Update the properties of a video.
 * @package Jwapi\Videos
 */
class Update extends Create
{
    //use Traits\VideoKey;

    /**
     * {@inherit}
     */
    protected $path = '/videos/update';

    /**
     * (required)
     * Key of the video you want data for.
     *
     * @param string $key
     *                    @return $this
     */
    public function setVideoKey($key)
    {
        $this->setGet('video_key', $key);

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
            throw new \InvalidArgumentException('Update video: Both download url and video file is set');
        }
    }
}
