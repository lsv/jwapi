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
namespace Jwapi\Traits;

/**
 * Class VideoKey
 * @package Jwapi\Traits
 */
trait VideoKey
{

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
