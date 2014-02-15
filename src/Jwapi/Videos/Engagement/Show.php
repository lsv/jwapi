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
namespace Jwapi\Videos\Engagement;

use Jwapi\Api\Api;

/**
 * Displays engagement analytics for a single video.
 * @package Jwapi\Videos\Engagement
 */
class Show extends Api
{
    //use Traits\VideoKey;

    /**
     * {@inherit}
     */
    protected $path = '/videos/engagement/show';

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
}
