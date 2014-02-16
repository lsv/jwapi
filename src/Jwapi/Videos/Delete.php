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

use Jwapi\Api\Api;
use Jwapi\Traits;

/**
 * Remove a video and all of its conversions from the server.
 * @package Jwapi\Videos
 */
class Delete extends Api
{
    use Traits\VideoKey;

    /**
     * {@inherit}
     */
    protected $path = '/videos/delete';

    /**
     * {@inherit}
     */
    protected $required = array(
        'video_key'
    );

}
