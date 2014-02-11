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
use Jwapi\Traits;

/**
 * Show video thumbnails creation status.
 * @package Jwapi\Videos\Thumbnails
 */
class Show extends Api
{
    use Traits\VideoKey;

    protected $url = '/videos/thumbnails/show';

} 